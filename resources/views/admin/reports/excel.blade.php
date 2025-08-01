<table>
    <thead>
        <tr>
            <th>Loại thống kê</th>
            <th>Giá trị</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Doanh thu hôm nay</td><td>{{ $revenueToday }}</td></tr>
        <tr><td>Doanh thu tháng</td><td>{{ $revenueMonth }}</td></tr>
        <tr><td>Tổng doanh thu</td><td>{{ $totalRevenue }}</td></tr>
        <tr><td>Tổng đơn hôm nay</td><td>{{ $totalOrdersToday }}</td></tr>
        <tr><td>Tổng đơn tháng</td><td>{{ $totalOrdersMonth }}</td></tr>
        <tr><td>Đơn đã duyệt</td><td>{{ $approvedOrders }}</td></tr>
        <tr><td>Đơn chờ duyệt</td><td>{{ $pendingOrders }}</td></tr>
        <tr><td>Đơn đã huỷ</td><td>{{ $rejectedOrders }}</td></tr>
    </tbody>
</table>
