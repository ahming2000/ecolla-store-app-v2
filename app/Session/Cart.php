<?php


namespace App\Session;


use App\Models\Customer;
use App\Models\Variation;
use Illuminate\Support\Facades\Session;

/**
 * Class Cart
 * @package App\Session
 */
class Cart
{
    public int $VERSION = 7;

    public static string $DEFAULT_ORDER_MODE = 'pickup';
    public static string $DEFAULT_SESSION_NAME = 'ecollaCart';
    private array $messages = [
        'ch' => [
            'addToCart_success' => "成功加入购物篮！<a href='/ch/cart'>点击</a>进入购物篮！",
            'addToCart_exceedStockLimit' => "库存已到上线！",
        ],
        'en' => [
            'addToCart_success' => "Add to cart successfully! <a href='/en/cart'>Click here</a> to redirect to cart page!",
            'addToCart_exceedStockLimit' => "Stock exceed the limit!",
        ],
    ];

    public array $cartItems;
    public string $orderMode;
    public bool $canCheckOut;
    public string $deliveryId;
    public Customer $customer;

    public function start(){

        if(session()->has(Cart::$DEFAULT_SESSION_NAME)){
            $this->pullSessionCart(session(Cart::$DEFAULT_SESSION_NAME));
        } else{
            $this->cartItems = array();
            $this->orderMode = Cart::$DEFAULT_ORDER_MODE;
            $this->canCheckOut = false;
            $this->deliveryId = "";
            $this->customer = new Customer();
            $this->pushSessionCart();
        }
    }

    /**
     * Not in use
     * @param array $cartItems
     * @param string $orderMode
     * @param bool $canCheckOut
     * @param string $deliveryId
     * @param Customer $customer
     */
    public function importCart(array $cartItems, string $orderMode, bool $canCheckOut, string $deliveryId, Customer $customer)
    {
        $this->cartItems = $cartItems;
        $this->orderMode = $orderMode;
        $this->canCheckOut = $canCheckOut;
        $this->deliveryId = $deliveryId;
        $this->customer = $customer;
    }

    /**
     * @param Variation $variation
     * @param $quantity
     */
    public function addItem(Variation $variation, $quantity){

        $hasNotDuplicated = true;

        foreach ($this->cartItems as $cartItem){
            if($cartItem->variation->id == $variation->id){
                // Check if the item quantity requested to add is exceed the max number of stock
                // Only add to max stock
                if($cartItem->quantity + $quantity > $cartItem->variation->stock){
                    $cartItem->quantity = $cartItem->variation->stock;
                    Session::flash('message', $this->messages[$this->getLang()]['addToCart_exceedStockLimit']);
                } else{
                    $cartItem->quantity += $quantity;
                    Session::flash('message', $this->messages[$this->getLang()]['addToCart_success']);
                }

                $hasNotDuplicated = false;
            }
        }

        if($hasNotDuplicated){
            $this->cartItems[] = new CartItem($variation, $quantity);
            Session::flash('message', $this->messages[$this->getLang()]['addToCart_success']);
        }

        $this->pushSessionCart();
    }

    /**
     * @param $barcode
     */
    public function deleteItem($barcode){
        for($i = 0; $i < sizeof($this->cartItems); $i++){
            if($this->cartItems[$i]->variation->barcode === $barcode){
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
     * @param $barcode
     * @param $quantity
     */
    public function editQuantity($barcode, $quantity){

        foreach ($this->cartItems as $cartItem){
            if($cartItem->variation->barcode === $barcode && $cartItem->quantity + $quantity >= 1){
                $cartItem->quantity += $quantity;
            }
        }

        $this->pushSessionCart();
    }

    public function resetCart(){
        unset($this->cartItems);
        $this->cartItems = array();
        $this->canCheckOut = false;
        $this->customer = new Customer(array_filter($this->customer->toArray(), function($key){ // Reset customer id
            return $key != 'id';
        }, ARRAY_FILTER_USE_KEY));
        $this->pushSessionCart();
    }

    public function changeOrderMode(string $mode){
        $this->orderMode = $mode;
        $this->pushSessionCart();
    }

    public function updateCustomerData($customerData){
        foreach ($customerData as $key => $value){
            $this->customer->setAttribute($key, $value);
        }

        $this->pushSessionCart();
    }

    public function updateOrderVerifyId($deliveryId){
        $this->deliveryId = $deliveryId['delivery_id'];
        $this->pushSessionCart();
    }

    private function canCheckOut(){
        if($this->orderMode == 'delivery'){
            if($this->customer->name != null && !empty($this->cartItems)){
                $this->canCheckOut = true;
            } else {
                $this->canCheckOut = false;
            }
        } else{
            if($this->deliveryId != "" && !empty($this->cartItems)){
                $this->canCheckOut = true;
            } else{
                $this->canCheckOut = false;
            }
        }

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

    /**
     * Pull the cart only if version is same, if not, reset instead
     * @param Cart $cart
     */
    private function pullSessionCart(Cart $cart){

        if($cart->VERSION == $this->VERSION){
            $this->cartItems = $cart->cartItems;
            $this->orderMode = $cart->orderMode;
            $this->canCheckOut = $cart->canCheckOut;
            $this->deliveryId = $cart->deliveryId;
            $this->customer = $cart->customer;
        } else{
            $this->cartItems = array();
            $this->orderMode = Cart::$DEFAULT_ORDER_MODE;
            $this->canCheckOut = false;
            $this->deliveryId = "";
            $this->customer = new Customer();
            $this->pushSessionCart();
        }

    }

    private function pushSessionCart(){
        $this->canCheckOut();
        session([Cart::$DEFAULT_SESSION_NAME => $this]);
    }

    public function getCartCount(): int
    {
        return sizeof($this->cartItems) ?? 0;
    }

    public function getSubTotal(): float
    {
        $total = 0.0;
        foreach($this->cartItems as $cartItem){
            $total += $cartItem->getSubPrice();
        }
        return $total;
    }

    public function getShippingFee(): float
    {
        $fee = 0.0;

        if(strtolower($this->orderMode) == 'delivery'){
            $fee = 3.0;
        }

        $this->pushSessionCart();
        return $fee;
    }

    private function getLang(){
        return substr($_SERVER['REQUEST_URI'], 1, 2);
    }

}
