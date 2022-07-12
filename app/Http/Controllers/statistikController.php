<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class statistikController extends Controller
{
    public function index()
    {
        return view('statistik.index');
    }
}
