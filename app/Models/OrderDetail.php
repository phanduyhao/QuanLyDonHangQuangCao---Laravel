<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'service_id',
        'quantity',
        'unit_price',
        'subtotal',
        'start_date',
        'end_date',
        'content',
        'additional_info',
    ];

    /**
     * Chi tiết này thuộc về một đơn hàng.
     */
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Chi tiết này liên quan đến một dịch vụ quảng cáo.
     */
    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}