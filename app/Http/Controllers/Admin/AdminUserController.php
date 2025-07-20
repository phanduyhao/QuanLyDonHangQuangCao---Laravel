<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminUserController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
    
        // Tìm kiếm theo ID
        if ($request->input('search_id')) {
            $query->where('id', $request->input('search_id'));
        }
    
        // Tìm kiếm theo tên
        if ($request->input('search_name')) {
            $query->where('name', 'LIKE', '%' . $request->input('search_name') . '%');
        }
    
        // Tìm kiếm theo email
        if ($request->input('search_email')) {
            $query->where('email', 'LIKE', '%' . $request->input('search_email') . '%');
        }
        // Tìm kiếm theo email
        if ($request->input('search_phone')) {
            $query->where('phone', 'LIKE', '%' . $request->input('search_phone') . '%');
        }
        // Tìm kiếm theo email
        if ($request->input('search_role')) {
            $query->where('role', 'LIKE', '%' . $request->input('search_role') . '%');
        }
        $users = $query->orderByDesc('id')->paginate(10);

        return view('admin.user.index',compact('users'),[
            'title' => 'Quản lý người dùng',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Không tìm thấy người dùng với ID: ' . $id
            ], 404); 
        }

        return response()->json($user); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ], [
            'name.required' => 'Vui lòng nhập tên!',
            'email.required' => 'Vui lòng Nhập Email!',
            'email.unique' => 'Email này đã tồn tại!',
        ]);

        // Cập nhật tên, email và số điện thoại
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->status = $request->status_user;

        // Cập nhật password nếu có giá trị
        if ($request->password != null) {
            $user->password = bcrypt($request->password); // Đảm bảo mật khẩu được mã hóa
        }

        // Lưu lại thay đổi
        $user->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
               'message' => 'Không tìm thấy người dùng với ID: '. $id
            ], 404); 
        }
        $user->delete();
        return response()->json([
           'message' => 'Đã xóa người dùng ID: '. $id
        ], 200);
    }
}
