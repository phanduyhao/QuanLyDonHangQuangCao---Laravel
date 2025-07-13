<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function home()
    {
        // Logic to retrieve and display home page data
        return view('home',[
            'title' => 'Trang chủ'
        ]);
    }
}