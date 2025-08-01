<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
    </style>
</head>

<body>

    <h2>Báo cáo doanh thu và đơn hàng</h2>
    <ul>
        <li>💰 Doanh thu hôm nay: {{ number_format($revenueToday, 0, ',', '.') }} đ</li>
        <li>📅 Doanh thu tháng: {{ number_format($revenueMonth, 0, ',', '.') }} đ</li>
        <li>📈 Tổng doanh thu: {{ number_format($totalRevenue, 0, ',', '.') }} đ</li>
        <li>🛒 Tổng đơn hôm nay: {{ $totalOrdersToday }}</li>
        <li>🗓️ Tổng đơn tháng: {{ $totalOrdersMonth }}</li>
        <li>✅ Đơn Đã duyệt: {{ $approvedOrders }}</li>
        <li>⏳ Đơn Chờ duyệt: {{ $pendingOrders }}</li>
        <li>❌ Đơn Đã huỷ: {{ $rejectedOrders }}</li>
    </ul>

</body>

</html>
