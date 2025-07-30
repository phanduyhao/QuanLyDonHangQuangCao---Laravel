<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    /**
     * Hiển thị danh sách liên hệ với bộ lọc tìm kiếm.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Tìm kiếm theo tên
        if ($request->filled('search_name')) {
            $query->where('name', 'LIKE', '%' . $request->search_name . '%');
        }

        // Tìm kiếm theo email
        if ($request->filled('search_email')) {
            $query->where('email', 'LIKE', '%' . $request->search_email . '%');
        }

        // Tìm kiếm theo số điện thoại
        if ($request->filled('search_phone')) {
            $query->where('phone', 'LIKE', '%' . $request->search_phone . '%');
        }

        // Tìm kiếm theo trạng thái đã đọc
        if ($request->filled('search_isRead')) {
            $isRead = $request->search_isRead == '1' ? 1 : 0;
            $query->where('isRead', $isRead);
        }

        // Phân trang kết quả
        $contacts = $query->orderByDesc('id')->paginate(10);

        return view('admin.contact.index', compact('contacts'), [
            'title' => 'Quản lý liên hệ',
        ]);
    }

    /**
     * Xem chi tiết 1 liên hệ.
     */
    public function show($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Không tìm thấy liên hệ với ID: ' . $id
            ], 404);
        }
        
         // Đánh dấu đã đọc
            $contact->isRead = 1;
            $contact->save();

        return response()->json($contact);
    }
}
