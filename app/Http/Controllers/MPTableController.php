<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\ArrayKey;

class MPTableController extends Controller
{
    public function index(Request $request){
        // Site
        $site = collect(DB::select(DB::raw("SELECT kodesite, namasite, lokasi
        FROM SITE
        WHERE status=1
        ORDER BY namasite")));

        // Main Data
        $data = DB::table('mp_biodata')
        ->select(DB::raw("
        site,
        NIK,
        nama,
        dept,
        jabatan,
        hpkary,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0 as tglLahir,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),mulaikerja)), '%Y')+0 as mulaikerja,
        id"))
        ->when(request()->site, function($data){
            $data = $data->where('kodesite', '=', request()->site);
        })
        ->when(request()->statusKaryawan, function($data){
            $data = $data->where('sttpegawai', '=', request()->statusKaryawan);
        })
        ->when(request()->nama, function($data){
            $data = $data->where('nama', 'like', '%'.request()->nama.'%');
        })
        ->orderBy('site')
        ->orderBy('nama')
        ->get();

        // dd($data[0]->key);

        if(request()->jenisTampilan == "0" || is_null(request()->jenisTampilan)){
            $data = $data->values()->paginate(request()->paginate ? request()->paginate : 50)->withQueryString();

            return view('mp.index', compact('site', 'data'));
        }
        else{
            $data = $data->values();
            // dd();
        
            return view('mp.index', compact('site', 'data'));
        }
        
    }
}