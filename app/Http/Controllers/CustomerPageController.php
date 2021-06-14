<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\SystemConfig;
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
            case 'updateOrderMode':
                $orderMode = request('mode');
                $cart->changeOrderMode($orderMode);
                break;
            case 'updateCustomerData':
                $orderMode = request('mode');

                if($orderMode == 'delivery'){
                    $customerData = request()->validate([
                        'name' => 'required',
                        'phone' => 'required',
                        'addressLine1' => 'required',
//                        'state' => 'required',
//                        'area' => 'required',
//                        'postal_code' => 'required'
                    ]);

                    $cart->changeOrderMode($orderMode);
                    $cart->updateCustomerData($customerData);
                } else if($orderMode == 'pickup'){
                    $pickUpData = request()->validate([
                        'delivery_id' => 'required'
                    ]);

                    $cart->changeOrderMode($orderMode);
                    $cart->updateOrderVerifyId($pickUpData);
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
