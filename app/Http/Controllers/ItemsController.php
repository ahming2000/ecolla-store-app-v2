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
    public function index(){

        $items = Item::join('item_utils', 'item_utils.item_id', '=', 'items.id')
            ->where('is_listed', '=', 1)
            ->paginate(1);
        $categories = Category::all();

        return view($this->getLang() . '.item.index', compact('items', 'categories'));
    }


    public function view(string $name){

        $i = DB::table('items')
            ->select('*')
            ->where('name','=',$name)
            ->orWhere('name_en', '=', $name)
            ->first();

        if($i == null){
            abort(404);
        }

        $item = Item::find($i->id);

        return view($this->getLang() . '.item.view', compact('item'));
    }

    public function addToCart(String $name){

        $data = request()->all();

        $v = DB::table('variations')
            ->select('*')
            ->where('barcode', '=', $data['barcode'])
            ->first();

        session(Cart::$DEFAULT_SESSION_NAME)->addItem(Variation::find($v->id), $data['quantity']);

        header('refresh: 0');
    }

}
