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
        'service_pricing_id',
        'campaign_name',
        'campaign_content',
        'start_date',
        'end_date',
        'number_of_days',
        'total_reach',
        'total_amount',
        'status',
        'payment_status',
        'rejection_reason',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'string',
        'payment_status' => 'string',
    ];

    /**
     * Đơn hàng này thuộc về một người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Đơn hàng này thuộc về một gói quảng cáo cụ thể.
     */
    public function servicePricing()
    {
        return $this->belongsTo(ServicePricing::class, 'service_pricing_id');
    }

}
