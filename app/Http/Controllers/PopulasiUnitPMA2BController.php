<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopulasiUnitPMA2BController extends Controller
{
    public function index()
    {
        $data = DB::table('pmaa2b')->select(DB::raw("
        COALESCE(nom_unit, '-- SUM --') nom_unit,
        SUM(IF((LEFT(KODE, 1)='0'),JAM,0)) AS WH,
        SUM(IF((LEFT(KODE, 1)='b'),JAM,0)) AS BD,
        SUM(IF((LEFT(KODE, 1)='s'),JAM,0)) AS STB,
        SUM(JAM) AS MOHH"))
        ->when((request()->bulan) == null, function($data){
            $bulan = Carbon::now();
            $data = $data->whereBetween('TGL', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()]);
        })
        ->when(request()->bulan, function($data){
            $bulan = Carbon::createFromFormat('Y-m', request()->bulan);
            $data = $data->whereBetween('TGL', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()]);
        })
        ->when(request()->site, function($data){
            $data = $data->where('kodesite', '=', request()->site);
        })
        ->groupBy(DB::raw("nom_unit WITH ROLLUP"))
        ->get();

        $site = collect(DB::select(DB::raw("SELECT kodesite, namasite, lokasi
        FROM SITE
        WHERE status=1
        ORDER BY namasite")));

        if(request()->jenisTampilan == "0" || is_null(request()->jenisTampilan)){
            $data = $data->values()->paginate(request()->paginate ? request()->paginate : 50)->withQueryString();

            return view('pma2b.populasi.index', compact('data', 'site'));
        }
        else{
            $data = $data->values();
            // dd();

            return view('pma2b.populasi.index', compact('data', 'site'));
        }
    }
}
