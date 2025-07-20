<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function home()
    {
        $services= Service::where('status', 'active')->get();
        // Logic to retrieve and display home page data
        return view('home',compact('services'),[
            'title' => 'Trang chủ'
        ]);
    }

     public function showService($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        return response()->json($service);
    }
}