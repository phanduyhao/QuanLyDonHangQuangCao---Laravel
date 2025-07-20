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
        'image',
        // 'pricing_model',
        // 'package_price',
        // 'package_duration_days',
        // 'impressions_per_day',
        'status',
    ];

    /**
     * Mỗi dịch vụ có thể có nhiều bảng giá.
     */
    public function pricings()
    {
    return $this->hasMany(ServicePricing::class, 'service_id');
    }
}
