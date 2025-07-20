<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    /**
     * Lấy danh sách các gói (pricings) của một dịch vụ.
     */
    public function getPricings($id)
    {
        $service = Service::with('pricings')->find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Không tìm thấy dịch vụ với ID: ' . $id
            ], 404);
        }

        return response()->json($service->pricings);
    }
}