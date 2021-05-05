<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getListedItemCount($id){
        $count = Item::join('category_item', 'category_item.item_id', 'items.id')
            ->join('categories', 'category_item.category_id', 'categories.id')
            ->join('item_utils', 'item_utils.item_id', 'items.id')
            ->where('categories.id', '=', $id)
            ->where('item_utils.is_listed', '=', 1)
            ->count();

        return $count;
    }

}
