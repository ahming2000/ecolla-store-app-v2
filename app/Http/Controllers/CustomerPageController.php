<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Variation;
use App\Session\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPageController extends Controller
{

    public function redirect(){
        $path = $_SERVER['REQUEST_URI'];
        return redirect('ch' . $path);
    }

    public function index(){

        $carousel_desc = [
            'id' => 'imgSlide',
            'interval' => '10000',
            'images' => [
                'img/ads/ads1.jpg',
                'img/ads/ads2.jpg',
                'img/ads/ads3.jpg'
            ]
        ];

        $hot_items_id = DB::table('items')
            ->select('items.id')
            ->join('category_item', 'category_item.item_id', 'items.id')
            ->join('categories', 'categories.id', 'category_item.category_id')
            ->where('categories.name', '=', '热卖')
            ->get();

        $idList = array();
        foreach ($hot_items_id as $i){
            $idList[] = $i->id;
        }

        $hot_items = Item::join('item_utils', 'item_utils.item_id', '=', 'items.id')
            ->where('item_utils.is_listed', '=', 1)
            ->whereIn('id', $idList)->get();

        $new_items_id = DB::table('items')
            ->select('items.id')
            ->join('category_item', 'category_item.item_id', 'items.id')
            ->join('categories', 'categories.id', 'category_item.category_id')
            ->where('categories.name', '=', '新品')
            ->get();

        $idList = array();
        foreach ($new_items_id as $i){
            $idList[] = $i->id;
        }

        $new_items = Item::join('item_utils', 'item_utils.item_id', '=', 'items.id')
            ->where('item_utils.is_listed', '=', 1)
            ->whereIn('id', $idList)->get();

        return view($this->getLang() . '.index', compact('carousel_desc', 'hot_items', 'new_items'));
    }

    public function about(){
        return view($this->getLang() . '.about');
    }

    public function paymentMethod()
    {
        return view($this->getLang() . '.payment-method');
    }

    public function cart()
    {
        // Reset Cart
//        session()->pull(Cart::$DEFAULT_SESSION_NAME);
        $cart = session(Cart::$DEFAULT_SESSION_NAME) ?? new Cart();
        $cart->start();

        return view($this->getLang() . '.cart', compact('cart'));
    }

    public function cartOperation()
    {
        $action = request()->get('action');
        $cart = session(Cart::$DEFAULT_SESSION_NAME);

        switch ($action){
            case 'updateCartSettings':
                $orderMode = request()->get('orderMode');

                if($orderMode == 'delivery' && request()->get('customerField') != null){
                    $customerData = request()->validate([
                        'name' => 'required',
                        'phone' => 'required',
                        'addressLine1' => 'required',
                        'state' => 'required',
                        'area' => 'required',
                        'postal_code' => 'required'
                    ]);

                    $cart->updateCustomerData($customerData);
                } else if($orderMode == 'pickup' && request()->get('orderVerifyIdField') != null){
                    $pickUpData = request()->validate([
                        'order_verify_id' => 'required'
                    ]);

                    $cart->updateOrderVerifyId($pickUpData);
                } else{
                    $cart->changeOrderMode($orderMode);
                }
                break;
            case 'quantityAdjust':
                $barcode = request()->get('barcode');
                $quantityToAdjust = request()->get('quantityToAdjust');
                $cart->editQuantity($barcode, $quantityToAdjust);
                break;
            case 'deleteItem':
                $barcode = request()->get('barcode');
                $cart->deleteItem($barcode);
                break;
            case 'resetCart':
                $cart->resetCart();
                break;
            default:
        }

        header('refresh: 0');
    }

}
