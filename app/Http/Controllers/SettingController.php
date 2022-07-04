<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $site = collect(DB::select(DB::raw("SELECT kodesite, namasite, lokasi
        FROM SITE
        WHERE status=1
        ORDER BY namasite")));

        // dd($site);

        return view('setting.index', compact('site'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required|string|max:50',
            'kodesite' => 'required|string|max:1',
            'sandi' => 'required',
        ]);


        if($request->file('pic') == ''){
            // dd($request);

            $user = User::findOrFail(Auth::user()->id);

            $user->update([
                'nama'          =>  $request->nama,
                'kodesite'      =>  $request->kodesite,
                'sandi'      =>  md5($request->sandi),
            ]);
        } else {

            $user = User::findOrFail(Auth::user()->id);

            Storage::disk('local')->delete('public/images/'.basename(Auth::user()->pic));

            $pic = $request->file('pic');
            $pic->storeAs('public/images', $pic->hashName());

            $user = User::findOrFail(Auth::user()->id);
            $user->update([
                'nama'          =>  $request->nama,
                'kodesite'      =>  $request->kodesite,
                'sandi'      =>  md5($request->sandi),
                'pic'           => $pic->hashName()
            ]);
        }
        
        return redirect()->route('profile.index');
    }
}
