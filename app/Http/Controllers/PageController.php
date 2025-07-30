<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('page.about', [
            'title' => 'Giới thiệu'
        ]);
    }

    public function contact()
    {
        return view('page.contact', [
            'title' => 'Liên hệ'
        ]);
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'Vui lòng nhập họ tên.',
            'name.string'      => 'Họ tên phải là chuỗi ký tự.',
            'name.max'         => 'Họ tên không được vượt quá 255 ký tự.',

            'email.required'   => 'Vui lòng nhập địa chỉ email.',
            'email.email'      => 'Địa chỉ email không hợp lệ.',
            'email.max'        => 'Email không được vượt quá 255 ký tự.',

            'phone.string'     => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max'        => 'Số điện thoại không được vượt quá 20 ký tự.',

            'message.required' => 'Vui lòng nhập nội dung liên hệ.',
            'message.string'   => 'Nội dung phải là chuỗi ký tự.',
            'message.max'      => 'Nội dung không được vượt quá 2000 ký tự.',
        ]);

        // Lưu vào CSDL
        $contact = Contact::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'message'    => $request->message,
            'isRead'   => 0,
        ]);

        // Gửi email đến hệ thống
        Mail::send('emails.contact_notify', ['contact' => $contact], function ($message) use ($contact) {
            $message->to(config('mail.from.address'), 'Admin')  // gửi đến email hệ thống
                ->subject('📬 Liên hệ mới từ: ' . $contact->name);
        });

        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ với chúng tôi!');
    }
}
