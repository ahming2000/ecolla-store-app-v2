<?php


namespace App\Session;


use App\Models\Variation;

/**
 * Class Cart
 * @package App\Session
 */
class Cart
{
    public string $DEFAULT_ORDER_MODE = 'pickup';
    public string $DEFAULT_SESSION_NAME = 'ecollaCart';

    public array $cartItems;
    public float $shippingFee;
    public string $orderMode;

    public function start(){
        session_start();

        if(isset($_SERVER[$this->DEFAULT_SESSION_NAME])){
            $this->pullSessionCart($_SERVER[$this->DEFAULT_SESSION_NAME]);
        } else{
            $this->cartItems = array();
            $this->shippingFee = 0.0;
            $this->orderMode = $this->DEFAULT_ORDER_MODE;
            $this->pushSessionCart();
        }
    }

    /**
     * @param array $cartItems
     * @param float $shippingFee
     * @param string $orderMode
     */
    public function importCart(array $cartItems, float $shippingFee, string $orderMode)
    {
        $this->cartItems = $cartItems;
        $this->shippingFee = $shippingFee;
        $this->orderMode = $orderMode;
    }

    /**
     * @param Variation $variation
     * @param $quantity
     */
    public function addItem(Variation $variation, $quantity){
        foreach ($this->cartItems as $cartItem){
            if($cartItem->variation === $variation){
                $cartItem->quantity += $quantity;
            }
        }

        $this->cartItems[] = $variation;
        $this->pushSessionCart();
    }

    /**
     * @param Variation $variation
     */
    public function deleteItem(Variation $variation){
        for($i = 0; $i < sizeof($this->cartItems); $i++){
            if($this->cartItems[$i]->variation === $variation){
                unset($this->cartItems[$i]);
                break;
            }
        }

        $newArray = array();
        foreach ($this->cartItems as $cartItem){
            $newArray[] = $cartItem;
        }
        $this->cartItems = $newArray;

        $this->pushSessionCart();
    }

    /**
     * @param $variation
     * @param $quantity
     */
    public function editQuantity($variation, $quantity){
        foreach ($this->cartItems as $cartItem){
            if($cartItem->variation === $variation){
                $cartItem->quantity += $quantity;
            }
        }

        $this->pushSessionCart();
    }

    /**
     *
     */
    public function resetCart(){
        session_destroy();
        unset($this->cartItems);
        $this->cartItems = array();
    }

    /**
     * @param Variation $variation
     * @return bool
     */
    public function isFound(Variation $variation): bool
    {
        foreach ($this->cartItems as $cartItem){
            if($cartItem->variation === $variation){
                return true;
            }
        }
        return false;
    }

    private function pullSessionCart(Cart $cart){
        $this->cartItems = $cart->cartItems;
        $this->shippingFee = $cart->shippingFee;
        $this->orderMode = $cart->orderMode;
    }

    private function pushSessionCart(){
        $_SERVER[$this->DEFAULT_SESSION_NAME] = $this;
    }

    public function getCartCount(): int
    {
        return sizeof($this->cartItems);
    }

    public function getSubTotal(): float
    {
        $total = 0.0;
        foreach($this->cartItems as $cartItem){
            $total += $cartItem->variation * $cartItem->quantity;
        }
        return $total;
    }

}
