<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class statistikController extends Controller
{
    public function index()
    {
        $data = DB::table('mp_biodata')
        ->select(DB::raw("
            Count(nik) as total,
            SUM(IF(sttpegawai='STAFF',1,0)) AS Total_staff,
            SUM(IF(sttpegawai='NON STAFF',1,0)) AS Total_non_staff,
            SUM(IF(KELAMIN='PRIA',1,0)) AS Total_pria,
            SUM(IF(KELAMIN='WANITA',1,0)) AS Total_perempuan,
            SUM(IF(DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0<20,1,0)) AS dibawah20,
            SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0>=20 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0<30),1,0)) AS diatas20,
            SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0>=30 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0<40),1,0)) AS diatas30,
            SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0>=40 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0<50),1,0)) AS diatas40,
            SUM(IF((DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0>=50 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0<60),1,0)) AS diatas50,
            SUM(IF(DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),tgllahir)), '%Y')+0>=60,1,0)) AS diatas60
        "))
        ->when(request()->site, function($data){
            $data = $data->where('kodesite', '=', request()->site); 
        })
        ->where('del', '=', 1)
        ->get();

        $jabatan = DB::table('mp_biodata')
        ->select(DB::raw("
            jabatan as KET,
            SUM(del) as Jum
        "))
        ->when(request()->site, function($data){
            $data = $data->where('kodesite', '=', request()->site); 
        })
        ->where('del', '=', 1)
        ->groupBy('jabatan')
        ->get();
        
        $sumJabatan = DB::table('mp_biodata')
        ->select(DB::raw("
            COUNT('jabatan') as total
        "))
        ->where('del', '=', 1)
        ->value('total');

        $dept = DB::table('mp_biodata')
        ->select(DB::raw("
            dept as KET,
            SUM(del) as Jum
        "))
        ->when(request()->site, function($data){
            $data = $data->where('kodesite', '=', request()->site); 
        })
        ->where('del', '=', 1)
        ->groupBy('dept')
        ->get();

        $alamat = DB::table('mp_biodata')
        ->select(DB::raw("
            kec as KET,
            SUM(del) as Jum
        "))
        ->when(request()->site, function($data){
            $data = $data->where('kodesite', '=', request()->site); 
        })
        ->where('del', '=', 1)
        ->groupBy('kec')
        ->get();

        // Making Pie Charts
        $dataPie = [];
        foreach($dept as $d){
            $dataPie['label'][] = $d->KET;
            $dataPie['data'][] = (int) $d->Jum;
        }

        $dataPie['chart_data'] = json_encode($dataPie);
        return view('statistik.index', compact('data', 'jabatan', 'sumJabatan', 'dept', 'alamat', 'dataPie'));
    }
}
