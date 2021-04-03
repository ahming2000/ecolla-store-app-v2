<?php


namespace App\Session;

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
        // If the cart item has no individual discount and it has wholesale discount
        if($this->variation->discount == null && !$this->variation->item->hasNoWholesale()){
            return $this->variation->price * $this->quantity * $this->variation->item->getWholesaleRate($this->quantity);
        } else{
            return $this->variation->price * $this->quantity * ($this->variation->discount->rate ?? 1.0);
        }
    }

}
