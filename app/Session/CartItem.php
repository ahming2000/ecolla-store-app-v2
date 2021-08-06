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

    public function getOriginalSubPrice(){
        return $this->variation->price * $this->quantity;
    }

    public function getSubPrice(){
        return $this->variation->price * $this->quantity * $this->getDiscountRate();
    }

    public function getDiscountRate(): float
    {
        $discount_rate = 1.0;
        if($this->variation->discount != null){ // If have variation discount, ignore wholesale discount
            $discount_rate = 1 - $this->variation->discount->rate;
        } else {
//            foreach($this->variation->item->getSortedWholesales() as $w){
//                if($this->quantity >= $w->min){ // If quantity is more than min
//                    if($w->max == null || $w->step == sizeof($this->variation->item->getSortedWholesales())){
//                        // If max is null (infinite quantity for this discount) or last wholesale
//                        $discount_rate = $w->rate;
//                    } else{
//                        if ($this->quantity <= $w->max){ // If the quantity is fall between min and max
//                            $discount_rate = $w->rate;
//                        }
//                    }
//                }
//            }
        }
        return $discount_rate;
    }

}
