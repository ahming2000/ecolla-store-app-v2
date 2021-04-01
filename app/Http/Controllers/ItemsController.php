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
            $whereClause = "(categories.name = '$category' OR categories.name_en = '$category') AND (items.name LIKE '%$search%' OR items.name_en LIKE '%$search%' OR items.origin LIKE '%$search%' OR items.origin_en LIKE '%$search%' OR items.brand LIKE '%$search%' OR items.brand_en LIKE '%$search%' OR items.desc LIKE '%$search%' OR variations.name1 LIKE '%$search%' OR variations.name2 LIKE '%$search%' OR variations.name1_en LIKE '%$search%' OR variations.name2_en LIKE '%$search%' OR variations.barcode LIKE '%$search%')";
        } else if ($search != ""){
            $whereClause = "items.name LIKE '%$search%' OR items.name_en LIKE '%$search%' OR items.origin LIKE '%$search%' OR items.origin_en LIKE '%$search%' OR items.brand LIKE '%$search%' OR items.brand_en LIKE '%$search%' OR items.desc LIKE '%$search%' OR variations.name1 LIKE '%$search%' OR variations.name2 LIKE '%$search%' OR variations.name1_en LIKE '%$search%' OR variations.name2_en LIKE '%$search%' OR variations.barcode LIKE '%$search%'";
        } else if ($category != ""){
            $whereClause = "categories.name = '$category' OR categories.name_en = '$category'";
        } else{
            $whereClause = "";
        }

        if($whereClause != ""){
            $items_table = DB::table('items')
                ->select('items.id')
                ->join('category_item', 'category_item.item_id', '=', 'items.id')
                ->join('categories', 'categories.id', '=', 'category_item.category_id')
                ->join('variations', 'variations.item_id', '=', 'items.id')
                ->whereRaw($whereClause)
                ->distinct('items.id')
                ->get();
        } else{
            $items_table = DB::table('items')
                ->select('items.id')
                ->get();
        }

        $idList = array();
        foreach ($items_table as $i){
            $idList[] = $i->id;
        }

        $items = Item::join('item_utils', 'item_utils.item_id', '=', 'items.id')
            ->where('item_utils.is_listed', '=', 1)
            ->whereIn('id', $idList)
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

        return view($this->getLang() . '.item.view', compact('item'));
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
