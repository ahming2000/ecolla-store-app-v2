<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemUtil;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(){

        $items = Item::join('item_utils', 'item_utils.item_id', '=', 'items.id')
            ->where('is_listed', '=', 1)->get();
        $categories = Category::all();

        return view($this->getLang() . '.item.index', compact('items', 'categories'));
    }


    public function view(){
        return view($this->getLang() . '.item.view');
    }

    private function getLang(){
        return substr($_SERVER['REQUEST_URI'], 1, 2);
    }

}
