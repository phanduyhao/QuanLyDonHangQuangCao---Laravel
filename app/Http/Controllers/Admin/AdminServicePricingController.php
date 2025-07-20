<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServicePricing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminServicePricingController extends Controller
{
    /**
     * Hiển thị danh sách bảng giá.
     */
    public function index(Request $request)
    {
        $query = ServicePricing::with('service');

        if ($request->filled('search_service')) {
            $query->whereHas('service', fn($q) =>
                $q->where('service_name', 'like', '%' . $request->search_service . '%')
            );
        }

        $pricings = $query->orderByDesc('id')->paginate(10);
        $services = Service::orderBy('service_name')->get();

        return view('admin.service.pricing', compact('pricings', 'services'),[
            'title' => 'Quản lý bảng giá dịch vụ',
        ]);
    }

    /**
     * Lấy chi tiết bảng giá theo ID (dùng Ajax).
     */
    public function show($id)
    {
        $pricing = ServicePricing::find($id);
        if (!$pricing) {
            return response()->json(['message' => "Không tìm thấy bảng giá với ID: $id"], 404);
        }
        return response()->json($pricing);
    }

    /**
     * Thêm mới bảng giá.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'impressions_per_day' => 'required|integer|min:0',
        ], [
            'service_id.required' => 'Vui lòng chọn dịch vụ!',
            'service_id.exists' => 'Dịch vụ không tồn tại!',
            'price.required' => 'Vui lòng nhập giá!',
            'price.numeric' => 'Giá phải là số!',
            'duration_days.integer' => 'Số ngày phải là số nguyên!',
            'impressions_per_day.required' => 'Vui lòng nhập lượt tiếp cận/ngày!',
            'impressions_per_day.integer' => 'Lượt tiếp cận phải là số nguyên!',
        ]);

        $servicePricing = new ServicePricing();
        $servicePricing->service_id = $request->service_id;
        $servicePricing->title = $request->title ?? 'Gói tự do';
        $servicePricing->price = $request->price;
        $servicePricing->duration_days = $request->duration_days ?? null;
        $servicePricing->impressions_per_day = $request->impressions_per_day;
        $servicePricing->save();

        return redirect()->back()->with('success', 'Đã thêm bảng giá thành công.');
    }


    /**
     * Cập nhật bảng giá.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'impressions_per_day' => 'required|integer|min:0',
        ], [
            'service_id.required' => 'Vui lòng chọn dịch vụ!',
            'service_id.exists' => 'Dịch vụ không tồn tại!',
            'price.required' => 'Vui lòng nhập giá!',
            'price.numeric' => 'Giá phải là số!',
            'duration_days.integer' => 'Số ngày phải là số nguyên!',
            'impressions_per_day.required' => 'Vui lòng nhập lượt tiếp cận/ngày!',
            'impressions_per_day.integer' => 'Lượt tiếp cận phải là số nguyên!',
        ]);

        // Gán lại dữ liệu vào model
        $servicePricing = ServicePricing::findOrFail($id);
        $servicePricing->service_id = $request->service_id;
        $servicePricing->title = $request->title ?? 'Gói tự do';
        $servicePricing->price = $request->price;
        $servicePricing->duration_days = $request->duration_days ?? null;
        $servicePricing->impressions_per_day = $request->impressions_per_day;

        // Lưu lại
        $servicePricing->save();

        return redirect()->back()->with('success', 'Cập nhật bảng giá thành công.');
    }

    /**
     * Xóa bảng giá.
     */
     public function destroy(string $id)
    {
        $service = ServicePricing::find($id);

        $service->delete();
        return redirect()->back()->with('success', 'Đã xóa bảng giá thành công.');

    }
}
