<?php

namespace App\Models;

use DateInterval;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getSubtotal(){
        $total = 0.0;
        foreach ($this->orderItems as $orderItem){
            $total += $orderItem->price * $orderItem->discount_rate * $orderItem->quantity;
        }
        return $total;
    }

    public function getStatusDesc(): string
    {
        switch ($this->status){
            case 'pending':
                return '准备中';
            case 'prepared':
                return '待收货';
            case 'refunded':
                return '已退款';
            case 'canceled':
                return '已取消';
            case 'completed':
                return '已完成';
            default:
                return 'Null';
        }
    }

    public function getOrderModeLabel(string $lang = ''): string
    {
        if($lang == 'en'){
            return $this->mode == 'pickup' ? 'Pick-up' : 'Delivery';
        } else{
            return $this->mode == 'pickup' ? '预购取货' : '外送';
        }
    }

    public function getOrderCreateDateTime($returnType = 'string')
    {
        try {
            $result = date_add(new DateTime($this->created_at), new DateInterval('PT8H')); // GMT +8
            if($returnType == 'object'){
                return $result;
            } else{
                return $result->format('Y-m-d H:i:s');
            }
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


}
