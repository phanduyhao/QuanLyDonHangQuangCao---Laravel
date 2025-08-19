<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng được duyệt</title>
</head>
<body>
    <h2>Xin chào {{ $order->user->name ?? 'bạn' }},</h2>
    <p>Đơn hàng <strong>{{ $order->order_code }}</strong> của bạn đã được duyệt.</p>
    <p>Nếu bạn cần hỗ trợ thêm, vui lòng liên hệ với chúng tôi.</p>
    <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
</body>
</html>
