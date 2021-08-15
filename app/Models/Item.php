<?php

namespace App\Models;

use App\Util\ImageHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getListedCount(): int
    {
        return Item::join('item_utils', 'item_utils.item_id', '=', 'items.id')->where('is_listed', '=', 1)->count();
    }

    public function getCoverImage(): string
    {
        $data = $this->images->toArray()[0]['image'] ?? "";
        if ($data == "") {
            foreach ($this->variations as $variation){
                if ($variation->image != null){
                    $data = $variation->image;
                    break;
                }
            }
        }
        return (new ImageHandler())->convertToDataURL($data, false) ?? "";
    }

    public function getPriceRange(): array
    {
        $max = 0.0;
        $min = 0.0;
        foreach($this->variations as $v){
            $price = $v['price'];

            if ($v->discount != null){
                $price = $price * $v->discount->getRate();
            }

            if($price > $max){
                $max = $price;
            }

            if($price < $min or $min == 0.0){
                $min = $price;
            }
        }
        $max = number_format($max, 2);
        $min = number_format($min, 2);
        return ['max' => $max, 'min' => $min];
    }

    public function getFirstVariation(){
        foreach ($this->variations as $v){
            return $v;
        }
        return null;
    }

    public function getSortedWholesales(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->discounts()->orderBy('step')->get();
    }

    public function getTotalImageCount(): int
    {
        $total = sizeof($this->images->toArray());
        foreach ($this->variations as $v){
            if($v->image != null){
                $total++;
            }
        }
        return $total;
    }

    public function getTotalStock(){
        $total = 0;
        foreach ($this->variations as $variation){
            $total += $variation->stock;
        }
        return $total;
    }

    public function variations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Variation::class, 'item_id', 'id');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemImage::class, 'item_id', 'id');
    }

    public function util(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ItemUtil::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function userRating(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemUserRating::class);
    }

    public function discounts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WholesaleDiscount::class);
    }
}
