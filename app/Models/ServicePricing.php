<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePricing extends Model
{
    use HasFactory;
    /**
     * Mỗi bảng giá thuộc về một dịch vụ.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
