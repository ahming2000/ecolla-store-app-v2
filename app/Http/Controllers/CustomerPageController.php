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


        $recommended_items_id = DB::table('items')
            ->select('items.id')
            ->join('category_item', 'category_item.item_id', 'items.id')
            ->join('categories', 'categories.id', 'category_item.category_id')
            ->where('categories.name', '=', '推荐')
            ->get();

        $idList = array();
        foreach ($recommended_items_id as $i){
            $idList[] = $i->id;
        }

        $recommended_items = Item::join('item_utils', 'item_utils.item_id', '=', 'items.id')
            ->where('item_utils.is_listed', '=', 1)
            ->whereIn('id', $idList)->get();


        $itemsGroup = [
            [
                'name' => '新品',
                'items' => $new_items
            ],
            [
                'name' => '热卖',
                'items' => $hot_items
            ],
            [
                'name' => '推荐',
                'items' => $recommended_items
            ]
        ];

        return view($this->getLang() . '.index', compact('carousel_desc', 'itemsGroup'));
    }

    public function about(){
        return view($this->getLang() . '.about');
    }

    public function paymentMethod()
    {
        $payments = [
            [
                'name' => 'Touch \'n Go',
                'code' => 'tng'
            ],
            [
                'name' => 'Boost Pay',
                'code' => 'boost'
            ],
            [
                'name' => 'Online Banking',
                'code' => 'online-banking'
            ],
            [
                'name' => 'Maybank QR Pay',
                'code' => 'maybank-qr-pay'
            ],
            [
                'name' => 'Quin Pay',
                'code' => 'quin-pay'
            ]
        ];
        return view($this->getLang() . '.payment-method', compact('payments'));
    }

    public function cart()
    {
        $cart = new Cart();
        $cart->start();

        return view($this->getLang() . '.cart', compact('cart'));
    }

    public function cartOperation()
    {
        $action = request('action');
        $cart = session(Cart::$DEFAULT_SESSION_NAME);

        switch ($action){
            case 'updateCartSettings':
                $orderMode = request()->get('orderMode');

                if($orderMode == 'delivery' && request()->get('customerField') != null){
                    $customerData = request()->validate([
                        'name' => 'required',
                        'phone' => 'required',
                        'addressLine1' => 'required',
//                        'state' => 'required',
//                        'area' => 'required',
//                        'postal_code' => 'required'
                    ]);

                    $cart->updateCustomerData($customerData);
                } else if($orderMode == 'pickup' && request()->get('orderVerifyIdField') != null){
                    $pickUpData = request()->validate([
                        'delivery_id' => 'required'
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
