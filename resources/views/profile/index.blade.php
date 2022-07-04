@extends('layouts.admin.app', ['title' => 'PMA 2023'])

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <!-- Remove everything INSIDE this div to a really blank page -->
        <div class="container px-6 mx-auto grid">
            <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
                Profile
            </h2>

            <div class="flex flex-col justify-center items-center bg-white py-10 px-2 rounded-lg w-1/4 mx-auto">
                <div class="relative mb-3">
                    <img class="w-40 h-40 rounded-full object-cover object-top" src="{{Auth::user()->pic}}" alt="">
                    <button class="absolute bottom-0 right-0 bg-green-600 text-white font-bold text-xl rounded-full hover:bg-green-700 py-2 px-3 duration-150 ease-in-out">+</button>
                </div>
                <div class="mb-7 font-bold text-lg">
                    {{Auth::user()->nama}}
                </div>

                <table class="mb-10">
                    <tr>
                        <th class="border p-10 text-left">
                            Nama
                        </th>
                        <td class="border p-10 text-center">
                            {{Auth::user()->nama}}
                        </td>
                    </tr>
                    <tr>
                        <th class="border p-10 text-left">
                            Penempatan
                        </th>
                        <td class="border p-10 text-center">
                            {{Auth::user()->kodesite}}
                        </td>
                    </tr>
                    <tr>
                        <th class="border p-10 text-left">
                            Status Pengguna
                        </th>
                        <td class="border p-10 text-center">
                            {{Auth::user()->golongan}}
                        </td>
                    </tr>
                </table>

                <a href="{{route('setting.index')}}" class="w-1/2 col-span-2 font-semibold text-xl bg-green-600 hover:bg-green-700 duration-150 ease-in-out p-3 text-white rounded-md shadow-lg text-center">
                    Ubah Profil
                </a>
            </div>
        </div>
    </main>
@endsection