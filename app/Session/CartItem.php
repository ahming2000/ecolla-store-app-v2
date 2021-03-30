<?php


namespace App\Session;


use App\Models\Item;
use App\Models\Variation;

class CartItem
{
    public Variation $variation;
    public int $quantity;

    /**
     * CartItem constructor.
     * @param Variation $variation
     * @param int $quantity
     */
    public function __construct(Variation $variation, int $quantity)
    {
        $this->variation = $variation;
        $this->quantity = $quantity;
    }


    public function getSubPrice(){
        return $this->variation->price * $this->quantity;
    }

}
