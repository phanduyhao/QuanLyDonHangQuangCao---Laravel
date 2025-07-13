<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_orders',
        'approved_orders',
        'rejected_orders',
        'total_revenue',
    ];
}