<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Payment_History;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment(Request $request, Order $order)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('checkout.complete', [
            'orderId' => $order->id,
            'amount_money' => $order->total
        ]);
        $vnp_TmnCode = "OKGS5CXM";
        $vnp_HashSecret = "248XXFTLPU48PYC1UDQT41TXA2LPV3SV";

        $vnp_TxnRef = 'ORD' . $order->id . time(); // Mã giao dịch
        $vnp_OrderInfo = "Thanh toán đơn hàng #" . $order->id;
        $vnp_OrderType = 'billpayment';
        $totalAmount = (int) str_replace(['.', ','], '', $order->total_amount);
        $vnp_Amount = $totalAmount ;

        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_BankCode = $request->bank_code ?? null;

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if ($vnp_BankCode) $inputData['vnp_BankCode'] = $vnp_BankCode;

        ksort($inputData);
        $query = "";
        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            $hashdata .= ($i++ ? '&' : '') . urlencode($key) . "=" . urlencode($value);
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '?' . $query . 'vnp_SecureHash=' . $vnpSecureHash;

        $Payment_History = Payment_History::create([
            'order_code' => $order->id,
            'user_id' => Auth::id(),
            'amount_money' => $order->total,
            'payment_status' => 0,
            'TransactionStatus' => 'pending',
        ]);

        log::info($Payment_History);

        return redirect($vnp_Url);
    }


    public function complete(Request $request, $orderId)
    {
        $vnpResponseCode = $request->query('vnp_ResponseCode');

        $payment = Payment_History::where('order_code', $orderId)->first();
        $order = Order::find($orderId);

        log::info($vnpResponseCode);
        log::info($orderId);
        if ($vnpResponseCode === '00') {
            $order->status = Order::STATUS_PENDING;
            $order->save();

            $payment->update([
                'payment_status' => 1,
                'TransactionStatus' => 'success',
                'vnp_BankTranNo' => $request->query('vnp_BankTranNo'),
                'vnp_ResponseCode' => $vnpResponseCode,
                'TransactionNo' => $orderId,
                'BankCode' => $request->query('vnp_BankCode')
            ]);

            return view('payment.vnpay_complete', compact('order'), [
                'title' => 'Thanh toán thành công!'
            ]);
        } else {
            $order->status = Order::PAYMENT_FAILED;
            $order->save();

            $payment?->update([
                'payment_status' => 0,
                'TransactionStatus' => 'failed',
                'vnp_ResponseCode' => $vnpResponseCode,
                'TransactionNo' => $orderId,
                'BankCode' => $request->query('vnp_BankCode')
            ]);

            return redirect()->route('checkout')->with('error', 'Thanh toán không thành công!');
        }
    }

}
