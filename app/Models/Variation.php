<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Variation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getDiscountMode(): string
    {
        $mode = 'normal';
        if($this->discount != null){ // If have variation discount, ignore wholesale discount
            $mode = 'variation';
        } else{
            if(!empty($this->item->getSortedWholesales()->toArray())){
                $mode = 'wholesale';
            }
        }
        return $mode;
    }

    public function getCurrentDiscountMode(int $quantity): string
    {
        $mode = 'normal';

        if($this->discount != null){ // If have variation discount, ignore wholesale discount
            $mode = 'variation';
        } else{
            foreach($this->item->getSortedWholesales() as $w){
                if($quantity >= $w->min){ // If quantity is more than min
                    $mode = 'wholesale';
                }
            }
        }
        return $mode;
    }

    public function item(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function discount(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(VariationDiscount::class);
    }

    public function inventories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}
