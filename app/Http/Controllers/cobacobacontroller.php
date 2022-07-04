<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class cobacobacontroller extends Controller
{
    public function index()
    {
        $tglAwal = Carbon::create()->day(1)->month(1)->year(2002);

        $file_sql = file_get_contents(base_path() . '\public\storage\testing.txt');

        $data = DB::select(DB::raw($file_sql));

        return view('cobacoba', compact('tglAwal', 'file_sql', 'data'));
    }
}
