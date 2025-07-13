<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'description',
        'price',
        'unit',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Dịch vụ này có nhiều chi tiết đơn hàng.
     */
    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'service_id', 'id');
    }
}