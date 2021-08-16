<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationDiscount extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getRate(): float
    {
        $now = date('Y-m-d H:i:s');

        if ($now < $this->start || $now > $this->end){
            return 1.0;
        } else {
            return (1 - $this->rate);
        }
    }

    public function variation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Variation::class);
    }
}
