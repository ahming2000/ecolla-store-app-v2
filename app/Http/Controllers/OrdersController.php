<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Session\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{

    public function checkOut()
    {
        $cart = session(Cart::$DEFAULT_SESSION_NAME) ?? new Cart();
        $cart->start();

        return view($this->getLang() . '.order.check-out', compact('cart'));
    }


    public function store()
    {

        $cart = session(Cart::$DEFAULT_SESSION_NAME);

        $orderData = request()->validate([
            'payment_method' => 'required',
            'receipt_image' => ['required', 'image']
        ]);

        $prefix = DB::table('system_configs')->where('name', '=', 'orderCodePrefix')->value('value');
        $dateTime = date('Y-m-d H:i:s');
        $orderId = $prefix . date_format(date_create($dateTime), "YmdHis");

        if($cart->orderMode == 'delivery'){
            $orderData = array_merge($orderData, [
                'code' => $orderId,
                'mode' => $cart->orderMode,
            ]);
        } else{
            $orderData = array_merge($orderData, [
                'code' => $orderId,
                'mode' => $cart->orderMode,
                'order_verify_id' => $cart->orderVerifyId
            ]);
        }

        // TODO Save order's items into the table


        $order = new Order();
        foreach ($orderData as $key => $value){
            $order->setAttribute($key, $value);
        }
        $order->save();

        if($cart->orderMode == 'delivery'){
            $customer = $cart->customer;
            $order->customer()->save($customer);
        }

        dd($order);
        //return view("ch.order.order-successfully");
    }

    public function orderTracking()
    {

        return view($this->getLang() . '.order.order-tracking');
    }


}
