@extends('layouts.admin.app', ['title' => 'PMA 2023'])

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <!-- Remove everything INSIDE this div to a really blank page -->
        <div class="container px-6 mx-auto grid">
            <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
                Pengaturan Akun
            </h2>

            <form method="POST" action="{{route('setting.update')}}" class="flex flex-col justify-center items-center bg-white py-10 px-2 rounded-lg">
                @csrf
                <div class="relative mb-10">
                    <img class="w-40 h-40 rounded-full object-cover object-top" src="{{Auth::user()->pic}}" alt="">
                    <button class="absolute bottom-0 right-0 bg-green-600 text-white font-bold text-xl rounded-full hover:bg-green-700 py-2 px-3 duration-150 ease-in-out">+</button>
                </div>

                <div class="grid grid-cols-2 gap-10">
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm mb-1 text-gray-600" for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="p-3 rounded-md border" value="{{Auth::user()->nama}}">
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm mb-1 text-gray-600" for="kodesite">Lokasi</label>
                        <select name="kodesite" id="kodesite" class="p-3 rounded-md border">
                            @foreach ($site as $st)
                                <option value="{{$st->kodesite}}" {{old('site', Auth::user()->kodesite) == $st->kodesite ? 'selected' : ''}}>{{$st->namasite}} - {{$st->lokasi}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label class="font-semibold text-sm mb-1 text-gray-600" for="sandi">Password</label>
                        <input type="password" name="sandi" id="sandi" class="p-3 rounded-md border">
                    </div>
                    <button class="col-span-2 font-semibold text-xl bg-green-600 hover:bg-green-700 duration-150 ease-in-out p-3 text-white rounded-md shadow-lg" type="submit">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </main>
@endsection