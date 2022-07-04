<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistribusiJamPMA2BController extends Controller
{
    public function index()
    {
        $data = DB::table('pmaa2b')->select(DB::raw("
        COALESCE(nom_unit, '-- SUM --') nom_unit,
        LEFT(nom_unit,4) K_kode,
        SUM(IF(kode='008',jam,0)) lr,                
        SUM(IF(kode='009',jam,0)) ll,                
        SUM(IF(kode='010',jam,0)) ls,                
        SUM(IF(kode='011',jam,0)) lb,                
        SUM(IF(kode='012',jam,0)) lm,                
        SUM(IF(kode='013',jam,0)) coal,        
        SUM(IF(kode='003',jam,0)) rip,                
        SUM(IF(kode='004',jam,0)) doz,                
        SUM(IF(kode='005',jam,0)) ripdoz,                
        SUM(IF(kode='006',jam,0)) spr,                
        SUM(IF(kode='022',jam,0)) drill,                
        SUM(IF((kode='017') OR
                  (kode='018'),jam,0)) maint,        
        SUM(IF(kode='014',jam,0)) clean,                
        SUM(IF(kode='001',jam,0)) land,                
        SUM(IF(kode='020',jam,0)) gen,                
        SUM(IF(kode='015',jam,0)) trav,                
        SUM(IF(kode='023',jam,0)) rent,                
        SUM(IF(LEFT(kode,1)='0',jam,0)) totalwh,
        SUM(IF(LEFT(kode,1)='B',jam,0)) bd,
        SUM(jam) AS mohh,
        SUM(IF(kode='s00',jam,0)) s00,
        SUM(IF(kode='s01',jam,0)) s01,
        SUM(IF(kode='s02',jam,0)) s02,
        SUM(IF(kode='s03',jam,0)) s03,
        SUM(IF(kode='s04',jam,0)) s04,
        SUM(IF(kode='s05',jam,0)) s05,
        SUM(IF(kode='s06',jam,0)) s06,
        SUM(IF(kode='s07',jam,0)) s07,
        SUM(IF(kode='s08',jam,0)) s08,
        SUM(IF(kode='s09',jam,0)) s09,
        SUM(IF(kode='s10',jam,0)) s10,
        SUM(IF(kode='s11',jam,0)) s11,
        SUM(IF(kode='s12',jam,0)) s12,
        SUM(IF(kode='s13',jam,0)) s13,
        SUM(IF(kode='s14',jam,0)) s14,
        SUM(IF(kode='s15',jam,0)) s15,
        SUM(IF(kode='s16',jam,0)) s16,
        SUM(IF(kode='s17',jam,0)) s17,
        SUM(IF(LEFT(kode,1)='S',jam,0)) total_stb"))
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
        ->groupBy(DB::raw("k_kode,nom_unit WITH ROLLUP"))
        ->get();

        $site = collect(DB::select(DB::raw("SELECT kodesite, namasite, lokasi
        FROM SITE
        WHERE status=1
        ORDER BY namasite")));

        if(request()->jenisTampilan == "0" || is_null(request()->jenisTampilan)){
            $data = $data->values()->paginate(request()->paginate ? request()->paginate : 50)->withQueryString();

            return view('pma2b.distribusi.index', compact('data', 'site'));
        }
        else{
            $data = $data->values();
            // dd();

            return view('pma2b.distribusi.index', compact('data', 'site'));
        }
    }
}
