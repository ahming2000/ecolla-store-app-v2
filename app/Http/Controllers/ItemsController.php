<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemUtil;
use App\Models\Variation;
use App\Session\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ItemsController extends Controller
{

    public function index()
    {

        $ITEM_PER_PAGE = DB::table('system_configs')->select('value')->where('name', '=', 'maxRecordsPerPage')->first()->value;

        $search = request()->get('search') ?? "";
        $category = request()->get('category') ?? "";

        if($search != "" && $category != ""){
            $whereClause = "(categories.name = '$category' OR categories.name_en = '$category')";
            $whereClause = $whereClause . "AND (items.name LIKE '%$search%' OR items.name_en LIKE '%$search%' OR items.origin LIKE '%$search%' OR items.origin_en LIKE '%$search%' OR items.desc LIKE '%$search%' OR variations.name LIKE '%$search%' OR variations.name_en LIKE '%$search%' OR variations.barcode LIKE '%$search%')";
            $whereClause = $whereClause . "AND item_utils.is_listed = 1";
        } else if ($search != ""){
            $whereClause = "(items.name LIKE '%$search%' OR items.name_en LIKE '%$search%' OR items.origin LIKE '%$search%' OR items.origin_en LIKE '%$search%' OR items.desc LIKE '%$search%' OR variations.name LIKE '%$search%' OR variations.name_en LIKE '%$search%' OR variations.barcode LIKE '%$search%')";
            $whereClause = $whereClause . "AND item_utils.is_listed = 1";
        } else if ($category != ""){
            $whereClause = "(categories.name = '$category' OR categories.name_en = '$category')";
            $whereClause = $whereClause . "AND item_utils.is_listed = 1";
        } else{
            $whereClause = "item_utils.is_listed = 1";
        }

        if($whereClause != ""){
            $items_table = DB::table('items')
                ->select('items.id')
                ->join('category_item', 'category_item.item_id', '=', 'items.id')
                ->join('categories', 'categories.id', '=', 'category_item.category_id')
                ->join('variations', 'variations.item_id', '=', 'items.id')
                ->join('item_utils', 'item_utils.item_id', '=', 'items.id')
                ->whereRaw($whereClause)
                ->distinct('items.id')
                ->get();
        } else{
            $items_table = DB::table('items')
                ->select('items.id')
                ->join('item_utils', 'item_utils.item_id', '=', 'items.id')
                ->get();
        }

        $items = Item::whereIn('id', array_column($items_table->toArray(), 'id'))
            ->orderBy('created_at', 'desc')
            ->paginate($ITEM_PER_PAGE);

        $categories = Category::all();

        // Custom link for laravel pagination
        if($search != "" && $category != ""){
            $parameter = "?search=$search&category=$category";
        } else if ($search != ""){
            $parameter = "?search=$search";
        } else if ($category != ""){
            $parameter = "?category=$category";
        } else{
            $parameter = "";
        }

        $items->withPath('/' . $this->getLang() . '/item' . $parameter);

        return view($this->getLang() . '.item.index', compact('items', 'categories'));
    }


    public function view(string $name)
    {

        $i = DB::table('items')
            ->join('item_utils', 'item_utils.item_id', '=', 'items.id')
            ->where('item_utils.is_listed', '=', 1)
            ->where('items.name', '=', $name)
            ->orWhere('items.name_en', '=', $name)
            ->first();

        if ($i == null) {
            abort(404);
        }

        $item = Item::find($i->id);
        $this->viewCountIncrement($item);

        $MAX_RECOMMEND_COUNT = 10;

        // Get random item
        if(Item::all()->count() < $MAX_RECOMMEND_COUNT){
            $randomItems = Item::all() ?? [];
        } else{
            $randomItems = Item::all()->random($MAX_RECOMMEND_COUNT) ?? [];
        }

        // Get same category item
        $mayLikeItems = [];
        $count = 0;
        $catIds = array_column($item->categories->toArray(), 'id');
        foreach ($catIds as $catId){
            if($catId > 10 && $count <= $MAX_RECOMMEND_COUNT){ // Skip default category
                $categoryItems = DB::table('category_item')->where('category_id', '=', $catId)->get()->toArray();
                foreach($categoryItems as $ci){
                    if($ci->item_id != $item->id) { // Avoid same item
                        $mayLikeItems[] = Item::find($ci->item_id);
                        $count++;
                    }
                }
            }
        }

        return view($this->getLang() . '.item.view', compact('item', 'randomItems', 'mayLikeItems'));
    }

    public function addToCart(string $name)
    {

        $data = request()->all();

        $v = DB::table('variations')
            ->select('*')
            ->where('barcode', '=', $data['barcode'])
            ->first();

        session(Cart::$DEFAULT_SESSION_NAME)->addItem(Variation::find($v->id), $data['quantity']);

        header('refresh: 0');
    }

    private function viewCountIncrement($item){
        $item
            ->util
            ->where('item_id', '=', $item->id)
            ->update(['view_count' => $item->util->view_count + 1]);
    }

}
