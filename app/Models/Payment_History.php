<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_History extends Model
{
    use HasFactory;
    protected $table = 'payment_histories';
    protected $fillable = [
    'order_code', 'user_id', 'amount_money', 'payment_status',
    'TransactionStatus', 'TransactionNo', 'BankCode',
    'vnp_BankTranNo', 'vnp_ResponseCode'
];

    public function User()
    {
        return $this->belongsTo( User::class, 'user_id','id');
    }
}
