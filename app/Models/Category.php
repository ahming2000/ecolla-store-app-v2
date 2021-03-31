<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static function getListedItemCount($id){
        $count = Item::join('classifications', 'classifications.item_id', 'items.id')
            ->join('categories', 'classifications.category_id', 'categories.id')
            ->join('item_utils', 'item_utils.item_id', 'items.id')
            ->where('categories.id', '=', $id)
            ->where('item_utils.is_listed', '=', 1)
            ->count();

        return $count;
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}
