<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function variations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Variation::class);
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemImage::class);
    }

    public function util(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ItemUtil::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Classification::class);
    }

    public function userRating(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemUserRating::class);
    }

    public function discount(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WholesaleDiscount::class);
    }
}
