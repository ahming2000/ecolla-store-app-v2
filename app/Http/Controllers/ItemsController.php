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

        $items_table = DB::table('items')
            ->select('items.id')
            ->join('item_utils', 'item_utils.item_id', '=', 'items.id')
            ->join('category_item', 'category_item.item_id', '=', 'items.id')
            ->join('variations', 'variations.item_id', '=', 'items.id')
            ->where('item_utils.is_listed', '=', 1)
            ->where('items.name', 'LIKE', "%{$search}%")
            ->orWhere('items.name_en', 'LIKE', "%{$search}%")
            ->orWhere('items.origin', 'LIKE', "%{$search}%")
            ->orWhere('items.origin_en', 'LIKE', "%{$search}%")
            ->orWhere('items.brand', 'LIKE', "%{$search}%")
            ->orWhere('items.brand_en', 'LIKE', "%{$search}%")
            ->orWhere('items.desc', 'LIKE', "%{$search}%")
            ->orWhere('variations.name1', 'LIKE', "%{$search}%")
            ->orWhere('variations.name2', 'LIKE', "%{$search}%")
            ->orWhere('variations.name1_en', 'LIKE', "%{$search}%")
            ->orWhere('variations.name2_en', 'LIKE', "%{$search}%")
            ->orWhere('variations.barcode', 'LIKE', "%{$search}%")
            ->distinct('items.id')
            ->get();

        $idList = array();
        foreach ($items_table as $i){
            $idList[] = $i->id;
        }

        $items = Item::whereIn('id', $idList)->paginate($ITEM_PER_PAGE);

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
            ->select('*')
            ->where('name', '=', $name)
            ->orWhere('name_en', '=', $name)
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
