<?php

namespace App\Http\Controllers;

use App\Exceptions\OrderLogicErrorException;
use App\Models\ItemUtil;
use App\Models\Order;
use App\Models\OrderItem;
use App\Session\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class OrdersController extends Controller
{

    public function checkOut()
    {
        $cart = new Cart();
        $cart->start();

        return view($this->getLang() . '.order.check-out', compact('cart'));
    }

    public function store()
    {

        $cart = new Cart();
        $cart->start();
        if(empty($cart->cartItems)) return redirect($this->getLang() . '/cart');

        // Check stock is available
        foreach ($cart->cartItems as $cartItem){
            if($cartItem->variation->getTotalStock() < $cartItem->quantity){
                $cart->resetCart();
                abort(419);
            }
        }

        $orderData = request()->validate([
            'payment_method' => 'required',
            'receipt_image' => ['required', 'image']
        ]);

        $prefix = DB::table('system_configs')->where('name', '=', 'orderCodePrefix')->value('value');
        $dateTime = date('Y-m-d H:i:s');
        $orderCode = $prefix . date_format(date_create($dateTime), "YmdHis");

        $imagePath = request('receipt_image')->store('receipts', 'public');
        Image::make(public_path("storage/$imagePath"))->save(); // Optimize image by default

        if($cart->orderMode == 'delivery'){
            $orderData = array_merge($orderData, [
                'code' => $orderCode,
                'mode' => $cart->orderMode,
            ]);
        } else{
            $orderData = array_merge($orderData, [
                'code' => $orderCode,
                'mode' => $cart->orderMode,
                'delivery_id' => $cart->deliveryId
            ]);
        }

        // $orderData['receipt_image'] = "http://www.newrainbowmarket.com/storage/" . $imagePath;
        $orderData['receipt_image'] = "http://ecolla.laravel/storage/" . $imagePath;


        $order = new Order();
        foreach ($orderData as $key => $value){
            $order->setAttribute($key, $value);
        }
        $order->save();

        foreach($cart->cartItems as $cartItem){

            $orderItem = new OrderItem();

            $orderItemDataList = array();

            if (empty($cartItem->variation->item->discounts)){
                $discountRate = $cartItem->variation->discount ?? 1.0;
            } else{
                $discountRate = $cartItem->variation->item->getWholesaleRate($cartItem->quantity) ?? 1.0;
            }

            $currentQuantity = $cartItem->quantity;
            foreach ($cartItem->variation->getSortedInventory() as $inv){

                if($inv->stock >= $currentQuantity){ // If selected expire date's stock is enough
                    $data = [
                        'order_id' => $order->id,
                        'name' => $cartItem->variation->item->name . ' ' . $cartItem->variation->name1 . ' ' . $cartItem->variation->name2,
                        'barcode' => $cartItem->variation->barcode,
                        'price' => $cartItem->variation->price,
                        'discount_rate' => $discountRate,
                        'quantity' => $currentQuantity,
                        'expire_date' => $inv->expire_date,
                    ];

                    // Modify inventory
                    $inv->stock -= $currentQuantity;
                    $currentQuantity = 0;

                } else{ // If the expire date's stock is not enough
                    $data = [
                        'order_id' => $order->id,
                        'name' => $cartItem->variation->item->name . ' ' . $cartItem->variation->name1 . ' ' . $cartItem->variation->name2,
                        'barcode' => $cartItem->variation->barcode,
                        'price' => $cartItem->variation->price,
                        'discount_rate' => $discountRate,
                        'quantity' => $inv->stock,
                        'expire_date' => $inv->expire_date,
                    ];

                    // Modify inventory
                    $currentQuantity -= $inv->stock;
                    $inv->stock = 0;
                }

                // Update Inventory Stock
                $inv->update(['stock']);
                $orderItemDataList[] = $data;
                if($currentQuantity == 0) break;
            }

            foreach ($orderItemDataList as $data){
                foreach ($data as $key => $value){
                    $orderItem->setAttribute($key, $value);
                }
            }
            $orderItem->save();

            $totalSold = $cartItem->variation->item->util->sold += $cartItem->quantity;
            ItemUtil::where('item_id', '=', $cartItem->variation->item->id)->update(['sold' => $totalSold]);
        }

        if($cart->orderMode == 'delivery'){
            $customer = $cart->customer;
            $order->customer()->save($customer);
        }

        $cart->resetCart();
        return redirect($this->getLang() . '/order-successful')->with('orderCode', $orderCode);
    }

    public function checkOutSuccess(){
        if(session('orderCode') == null){
            abort(419); // Order code didn't define
        } else{
            return view($this->getLang() . '.order.order-successful');
        }
    }

    public function orderTracking()
    {
        $message = "";

        $code = request('code');

        if($code != null){
            $order = DB::table('orders')->whereIn('code', [$code])->first();
            if($order != null){
                if($order->mode == 'delivery'){
                    switch ($order->status){
                        case 'pending':
                            $message = $this->getLang() == 'ch' ? "订单正在处理中" : "Processing Order";
                            break;
                        case 'prepared':
                            $message = $this->getLang() == 'ch' ? "订单已出货" : "Order is delivered";
                            break;
                        case 'completed':
                            $message = $this->getLang() == 'ch' ? "订单已完成" : "Order is completed";
                            break;
                        case 'refunded':
                            $message = $this->getLang() == 'ch' ? "订单已退款" : "Order is refunded";
                            break;
                        case 'canceled':
                            $message = $this->getLang() == 'ch' ? "订单已取消" : "Order is cancelled";
                            break;
                        default:
                            $message = "Null";
                    }
                } else{
                    switch ($order->status){
                        case 'pending':
                            $message = $this->getLang() == 'ch' ? "订单正在准备中" : "Preparing Order";
                            break;
                        case 'prepared':
                            $message = $this->getLang() == 'ch' ? "订单已准备完毕，请到店里取货" : "Order is well prepared, please pick up at the store.";
                            break;
                        case 'completed':
                            $message = $this->getLang() == 'ch' ? "订单已完成" : "Order is completed";
                            break;
                        case 'refunded':
                            $message = $this->getLang() == 'ch' ? "订单已退款" : "Order is refunded";
                            break;
                        case 'canceled':
                            $message = $this->getLang() == 'ch' ? "订单已取消" : "Order is cancelled";
                            break;
                        default:
                            $message = 'Null';
                    }
                }
            } else{
                $message = $this->getLang() == 'ch' ? "订单不存在" : "Order not found";
            }

        }

        return view($this->getLang() . '.order.order-tracking', compact('message'));
    }

}
