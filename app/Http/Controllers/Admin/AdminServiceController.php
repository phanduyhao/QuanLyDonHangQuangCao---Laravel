<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::query();
    
        // Tìm kiếm theo ID
        if ($request->input('search_id')) {
            $query->where('id', $request->input('search_id'));
        }
    
        // Tìm kiếm theo tên
        if ($request->input('search_name')) {
            $query->where('service_name', 'LIKE', '%' . $request->input('search_name') . '%');
        }
    
        // Tìm kiếm theo email
        if ($request->input('search_status')) {
            $query->where('status', 'LIKE', '%' . $request->input('search_status') . '%');
        }
        $services = $query->orderByDesc('id')->paginate(10);

        return view('admin.service.index',compact('services'),[
            'title' => 'Quản lý dịch vụ',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Không tìm thấy người dùng với ID: ' . $id
            ], 404); 
        }

        return response()->json($service); 
    }

     /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $this->validate($request, [
        'service_name' => 'required|unique:services',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:3000',
        // 'pricing_model' => 'required|string',
        // 'package_price' => 'nullable|numeric|min:0',
        // 'package_duration_days' => 'nullable|integer|min:1',
        // 'impressions_per_day' => 'nullable|integer|min:0',
        'status' => 'required|in:active,inactive',
    ], [
        // Thông báo lỗi cho các trường bắt buộc
        'service_name.required' => 'Tên dịch vụ là bắt buộc.',
        'service_name.unique' => 'Tên dịch vụ này đã tồn tại.',
        'pricing_model.required' => 'Mô hình định giá là bắt buộc.',
        'status.required' => 'Trạng thái là bắt buộc.',
        
        // Thông báo lỗi cho trường số
        // 'package_price.numeric' => 'Giá gói phải là một số.',
        // 'package_price.min' => 'Giá gói không được nhỏ hơn 0.',
        // 'package_duration_days.integer' => 'Thời gian chạy phải là một số nguyên.',
        // 'package_duration_days.min' => 'Thời gian chạy không được nhỏ hơn 1 ngày.',
        // 'impressions_per_day.integer' => 'Lượt tiếp cận phải là một số nguyên.',
        // 'impressions_per_day.min' => 'Lượt tiếp cận không được nhỏ hơn 0.',
        
        // Thông báo lỗi cho trường file
        'image.image' => 'File tải lên phải là một ảnh.',
        'image.max' => 'Kích thước ảnh không được vượt quá 3MB.',
    ]);

    $service = new Service();
    $service->service_name = $request->service_name;
    $service->description = $request->description;
    // $service->pricing_model = $request->pricing_model;
    // $service->package_price = $request->package_price;
    // $service->package_duration_days = $request->package_duration_days;
    // $service->impressions_per_day = $request->impressions_per_day;
    $service->status = $request->status;

    // Xử lý upload ảnh
    if ($request->hasFile('image')) {
        $filename = Str::slug($request->service_name) . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('images/services'), $filename);
        $service->image = $filename;
    }

    $service->save();

    return redirect()->route('services.index')->with('success', 'Thêm mới dịch vụ thành công!');
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // Sửa lại validate để đúng với Service model
        $this->validate($request, [
            'service_name' => [
                'required',
                'string',
                Rule::unique('services')->ignore($service->id),
            ],
            'description' => 'nullable|string',
            // 'pricing_model' => 'required|string',
            // 'package_price' => 'nullable|numeric|min:0',
            // 'impressions_per_day' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ], [
            'service_name.required' => 'Tên dịch vụ là bắt buộc.',
            'service_name.unique' => 'Tên dịch vụ này đã tồn tại.',
            'pricing_model.required' => 'Mô hình định giá là bắt buộc.',
            // 'package_price.numeric' => 'Giá gói phải là một số.',
            // 'package_price.min' => 'Giá gói không được nhỏ hơn 0.',
            // 'impressions_per_day.integer' => 'Lượt tiếp cận phải là một số nguyên.',
            // 'impressions_per_day.min' => 'Lượt tiếp cận không được nhỏ hơn 0.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ]);

        // Cập nhật dữ liệu của dịch vụ
        $service->service_name = $request->input('service_name');
        $service->description = $request->input('description');
        // $service->pricing_model = $request->input('pricing_model');
        // $service->package_price = $request->input('package_price');
        // $service->impressions_per_day = $request->input('impressions_per_day');
        $service->status = $request->input('status');

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            $filename = Str::slug($service->service_name) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images/services'), $filename);
            $service->image = $filename;
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'Cập nhật dịch vụ thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
               'message' => 'Không tìm thấy người dùng với ID: '. $id
            ], 404); 
        }
        $service->delete();
        return response()->json([
           'message' => 'Đã xóa người dùng ID: '. $id
        ], 200);
    }
}
