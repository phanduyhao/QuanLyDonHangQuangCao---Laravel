<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function about()
    {
        return view('page.about',[
            'title' => 'Giới thiệu'
        ]);
    }

    public function contact()
    {
        return view('page.contact',[
            'title' => 'Liên hệ'
        ]);
    }
}