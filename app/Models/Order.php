<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'rejection_reason',
    ];

    protected $casts = [
        'status' => 'string',
        'payment_status' => 'string',
    ];

    /**
     * Đơn hàng này thuộc về một người dùng.
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Đơn hàng này có nhiều chi tiết đơn hàng.
     */
    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    /**
     * Đơn hàng này có một thông báo cuối cùng (khi được duyệt hoặc từ chối).
     */
    public function LatestNotification()
    {
        return $this->belongsTo(Notification::class, 'order_id', 'id')->latestOfMany();
    }
}