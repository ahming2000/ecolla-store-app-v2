<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{

    public function store()
    {

        $customerData = request()->validate([
            'first_name' => 'required',
            'phone' => 'required',
            'addressLine1' => 'required',
            'state' => 'required',
            'area' => 'required',
            'postal_code' => 'required'
        ]);

        $orderData = request()->validate([
            'payment_method' => 'required',
            'receipt_image' => ['required', 'image']
        ]);

        $prefix = DB::table('system_configs')->where('name', '=', 'orderCodePrefix')->value('value');
        $dateTime = date('Y-m-d H:i:s');
        $orderId = $prefix . date_format(date_create($dateTime), "YmdHis");
        $orderData = array_merge($orderData, ['order_code' => $orderId]);

        $order = new Order();
        foreach ($orderData as $key => $value){
            $order->setAttribute($key, $value);
        }
        $order->save();

        $customerData = array_merge($customerData, ['order_id'=> $order->id]);
        $customer = new Customer();
        foreach ($customerData as $key => $value) {
            $customer->setAttribute($key, $value);
        }
        $order->customer()->save($customer);


        dd($order);
        //return view("ch.order.order-successfully");
    }

    public function orderTracking()
    {

        return view($this->getLang() . '.order-tracking');
    }

    public function cart()
    {
        return view($this->getLang() . '.cart');
    }

    public function paymentMethod()
    {
        return view($this->getLang() . '.payment-method');
    }

    public function checkOut()
    {
        return view($this->getLang() . '.check-out');
    }

}
