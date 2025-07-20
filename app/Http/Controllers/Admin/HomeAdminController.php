<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
class HomeAdminController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display home page data
        return view('admin.dasboard',[
            'title' => 'Trang quản trị'
        ]);
    }
}