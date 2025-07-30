<h2>📩 Thông báo liên hệ mới</h2>

<p><strong>Họ tên:</strong> {{ $contact->name }}</p>
<p><strong>Email:</strong> {{ $contact->email }}</p>
<p><strong>Điện thoại:</strong> {{ $contact->phone ?? 'Không có' }}</p>
<p><strong>Nội dung:</strong><br>{{ $contact->message }}</p>
