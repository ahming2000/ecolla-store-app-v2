<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'name_en', 'desc', 'origin', 'origin_en', 'brand', 'brand_en'];

    public static function getListedCount(): int
    {
        return Item::join('item_utils', 'item_utils.item_id', '=', 'items.id')->where('is_listed', '=', 1)->count();
    }

    public function getCoverImage(): string
    {
        $value = "";
        foreach($this->images as $i){
            $value = $i['image'];
            break;
        }
        return $value;
    }

    public function getPriceRange(): array
    {
        $max = 0.0;
        $min = 0.0;
        foreach($this->variations as $v){
            $price = $v['price'];
            // TODO - check the discount price also

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
    }

    public function getSortedWholesales(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->discounts()->orderBy('step')->get();
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
