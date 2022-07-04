<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class TPController extends Controller
{
    public function index()
    {
        $data = DB::table('pmatp')->select(DB::raw("NOM_UNIT,
        SUM(IF(AKTIVITAS='001',JAM,0)) AS OB,
        SUM(IF(AKTIVITAS='002',JAM,0)) AS ROOM,
        SUM(IF(AKTIVITAS='004',JAM,0)) AS POR,
        SUM(IF(AKTIVITAS='015',JAM,0)) AS TRAV,
        SUM(IF(AKTIVITAS='020',JAM,0)) AS GEN,
        SUM(IF(AKTIVITAS='023',JAM,0)) AS RENT,
        SUM(IF((LEFT(AKTIVITAS, 1)='0'),JAM,0)) AS TOTAL,
        SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0)) AS BD,
        SUM(IF(AKTIVITAS='SOO',JAM,0)) AS S00,
        SUM(IF(AKTIVITAS='SO1',JAM,0)) AS S01,
        SUM(IF(AKTIVITAS='SO2',JAM,0)) AS S02,
        SUM(IF(AKTIVITAS='SO3',JAM,0)) AS S03,
        SUM(IF(AKTIVITAS='SO4',JAM,0)) AS S04,
        SUM(IF(AKTIVITAS='SO5',JAM,0)) AS S05,
        SUM(IF(AKTIVITAS='SO6',JAM,0)) AS S06,
        SUM(IF(AKTIVITAS='SO7',JAM,0)) AS S07,
        SUM(IF(AKTIVITAS='SO8',JAM,0)) AS S08,
        SUM(IF(AKTIVITAS='SO9',JAM,0)) AS S09,
        SUM(IF(AKTIVITAS='S10',JAM,0)) AS S10,
        SUM(IF(AKTIVITAS='S11',JAM,0)) AS S11,
        SUM(IF(AKTIVITAS='S12',JAM,0)) AS S12,
        SUM(IF(AKTIVITAS='S13',JAM,0)) AS S13,
        SUM(IF(AKTIVITAS='S14',JAM,0)) AS S14,
        SUM(IF(AKTIVITAS='S15',JAM,0)) AS S15,
        SUM(IF(AKTIVITAS='S16',JAM,0)) AS S16,
        SUM(IF(AKTIVITAS='S17',JAM,0)) AS S17,
        SUM(IF((LEFT(AKTIVITAS, 1)='S'),JAM,0)) AS STB,
        SUM(JAM) AS MOHH,
        ((SUM(JAM) - SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0))) / SUM(JAM) ) * 100 AS MA,
        (SUM(IF((LEFT(AKTIVITAS, 1)='0'),JAM,0)) / (SUM(JAM) - SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0)))) * 100 AS UT"))
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
        ->groupBy('NOM_UNIT')
        ->get();

        $site = collect(DB::select(DB::raw("SELECT kodesite, namasite, lokasi
        FROM SITE
        WHERE status=1
        ORDER BY namasite")));

        $filter = $data->toBase()
        ->map(function($value){
            $value->NOM_UNIT_2 = substr($value->NOM_UNIT,0,2);  
            return $value;
        })
        ->groupBy('NOM_UNIT_2')
        ->mapWithKeys(function($group, $key){
            return [$key => (object)[
                'OB' => $group->sum('OB'),
                'ROOM' => $group->sum('ROOM'),
                'POR' => $group->sum('POR'),
                'TRAV' => $group->sum('TRAV'),
                'GEN' => $group->sum('GEN'),
                'RENT' => $group->sum('RENT'),
                'TOTAL' => $group->sum('TOTAL'),
                'BD' => $group->sum('BD'),
                'S00' => $group->sum('S00'),
                'S01' => $group->sum('S01'),
                'S02' => $group->sum('S02'),
                'S03' => $group->sum('S03'),
                'S04' => $group->sum('S04'),
                'S05' => $group->sum('S05'),
                'S06' => $group->sum('S06'),
                'S07' => $group->sum('S07'),
                'S08' => $group->sum('S08'),
                'S09' => $group->sum('S09'),
                'S10' => $group->sum('S10'),
                'S11' => $group->sum('S11'),
                'S12' => $group->sum('S12'),
                'S13' => $group->sum('S13'),
                'S14' => $group->sum('S14'),
                'S15' => $group->sum('S15'),
                'S16' => $group->sum('S16'),
                'S17' => $group->sum('S17'),
                'STB' => $group->sum('STB'),
                'MOHH' => $group->sum('MOHH'),
                'MA' => $group->sum('MA'),
                'UT' => $group->sum('UT'),
            ]];
        });
        // dd(request()->jenisTampilan);

        if(request()->jenisTampilan == "0" || is_null(request()->jenisTampilan)){
            $data = $data->values()->paginate(request()->paginate ? request()->paginate : 50)->withQueryString();

            return view('distribusi-jam-tp.index', compact('site', 'data', 'filter'));
        }
        else{
            $data = $data->values();
            // dd();

            return view('distribusi-jam-tp.index', compact('site', 'data', 'filter'));
        }
    }

    public function downloadPDF()
    {
        $data = DB::table('pmatp')->select(DB::raw("NOM_UNIT,
        SUM(IF(AKTIVITAS='001',JAM,0)) AS OB,
        SUM(IF(AKTIVITAS='002',JAM,0)) AS ROOM,
        SUM(IF(AKTIVITAS='004',JAM,0)) AS POR,
        SUM(IF(AKTIVITAS='015',JAM,0)) AS TRAV,
        SUM(IF(AKTIVITAS='020',JAM,0)) AS GEN,
        SUM(IF(AKTIVITAS='023',JAM,0)) AS RENT,
        SUM(IF((LEFT(AKTIVITAS, 1)='0'),JAM,0)) AS TOTAL,
        SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0)) AS BD,
        SUM(IF(AKTIVITAS='SOO',JAM,0)) AS S00,
        SUM(IF(AKTIVITAS='SO1',JAM,0)) AS S01,
        SUM(IF(AKTIVITAS='SO2',JAM,0)) AS S02,
        SUM(IF(AKTIVITAS='SO3',JAM,0)) AS S03,
        SUM(IF(AKTIVITAS='SO4',JAM,0)) AS S04,
        SUM(IF(AKTIVITAS='SO5',JAM,0)) AS S05,
        SUM(IF(AKTIVITAS='SO6',JAM,0)) AS S06,
        SUM(IF(AKTIVITAS='SO7',JAM,0)) AS S07,
        SUM(IF(AKTIVITAS='SO8',JAM,0)) AS S08,
        SUM(IF(AKTIVITAS='SO9',JAM,0)) AS S09,
        SUM(IF(AKTIVITAS='S10',JAM,0)) AS S10,
        SUM(IF(AKTIVITAS='S11',JAM,0)) AS S11,
        SUM(IF(AKTIVITAS='S12',JAM,0)) AS S12,
        SUM(IF(AKTIVITAS='S13',JAM,0)) AS S13,
        SUM(IF(AKTIVITAS='S14',JAM,0)) AS S14,
        SUM(IF(AKTIVITAS='S15',JAM,0)) AS S15,
        SUM(IF(AKTIVITAS='S16',JAM,0)) AS S16,
        SUM(IF(AKTIVITAS='S17',JAM,0)) AS S17,
        SUM(IF((LEFT(AKTIVITAS, 1)='S'),JAM,0)) AS STB,
        SUM(JAM) AS MOHH,
        ((SUM(JAM) - SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0))) / SUM(JAM) ) * 100 AS MA,
        (SUM(IF((LEFT(AKTIVITAS, 1)='0'),JAM,0)) / (SUM(JAM) - SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0)))) * 100 AS UT"))
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
        ->groupBy('NOM_UNIT')
        ->get();
        
        $pdf = PDF::loadView('distribusi-jam-tp.pdf', compact('data'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('Laporan.pdf');
    }
}
