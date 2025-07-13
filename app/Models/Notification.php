<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'notification_type',
        'message',
        'is_read',
        'sent_email',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'sent_email' => 'boolean',
    ];

    /**
     * Thông báo này thuộc về một người dùng.
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Thông báo này liên quan đến một đơn hàng.
     */
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}