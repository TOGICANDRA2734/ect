@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Tabel MP
        </h2>

        <form action="{{route('mp.index')}}" method="GET" class="grid grid-cols-3 gap-4">
            <div class="">
                <label fo class="font-bold pb-1 text-sm" for="site">Nama Site</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="site" id="site">
                    <option value="" selected>Semua Site</option>

                    @foreach ($site as $st)
                        <option value="{{$st->kodesite}}" {{old('site', request()->site) == $st->kodesite ? 'selected' : ''}}>{{$st->namasite}} - {{$st->lokasi}}</option>
                    @endforeach
                </select>
            </div>

            <div class="">
                <label class="font-bold pb-1 text-sm" for="statusKaryawan">Status Karyawan</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="statusKaryawan" id="statusKaryawan">
                    <option value="">Semua</option>
                    <option value="STAFF">Staff</option>
                    <option value="NON STAFF">Non-Staff</option>
                </select>
            </div>

            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Cari</button>
        </form>

        <form class="flex justify-end mt-5" action="{{route('mp.index')}}" method="GET">
            <input name="nama" id="nama" type="text" placeholder="Cari data" class="p-2 rounded-md mr-3" autocomplete="off">
            <button
                class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-600 border border-transparent rounded-md active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple"
            >
                Cari
            </button>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto">
                <table id="mp" class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border-b border-r border-stone">Site</th>
                            <th class="px-4 py-3 border-b border-r border-stone">NIK</th>
                            <th class="px-4 py-3 text-center border-r">Nama Karyawan</th>
                            <th class="px-4 py-3 text-center border-r">Departemen</th>
                            <th class="px-4 py-3 text-center border-r">Jabatan</th>
                            <th class="px-4 py-3 text-center border-r">No Kontak</th>
                            <th class="px-4 py-3 text-center border-r">Usia</th>
                            <th class="px-4 py-3 text-center border-r">Masa Kerja</th>
                            <th class="px-4 py-3 text-center border-r">Detail</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $dt)
                            <tr>
                                @foreach($dt as $key => $values)
                                    @if($key == "id")
                                        <td class="bg-red-100 flex align-middle">
                                            <button @click="openModal2" name="tbDetail" class="tbDetail border bg-black text-white p-2" value="{{$values}}">{{$values}}</button>
                                        </td>
                                    @else
                                        <td>{{$values}}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        
                    
                        <!-- @foreach($data as $dt)
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                @foreach($dt as $key => $value)
                                    <td class="px-4 py-3 text-sm">
                                        {{$value}} 
                                    </td>
                                @endforeach
                                <td>
                                    {{$dt->id}}
                                    <button @click="openModal2" data-id="{{$dt->id}}" class="edit-modal px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-800 border border-transparent rounded-lg active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple">
                                        Detail
                                    </button>
                                </td>
                            </tr>                    
                        @endforeach -->
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
                {{$data->links()}}
            </div>
        </div>
</main>

<script>        
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700');
        $(el).addClass('bg-gray-200', 'text-white');
    };  
</script>
@endsection

@section('javascripts')
<script>
    $('.tbDetail').on('click', function(){
        console.log($(this).val())
    })

    
</script>
@endsection


@section('modal-body')



<!--     
    <input type="text" name="nama" id="nama">
    <div class="grid grid-cols-1">
        <table class="mb-5">
            <thead>
                <tr>
                    <th class="border px-2 py-3">Nama</th>
                    <th class="border px-2 py-3">NIK</th>
                    <th class="border px-2 py-3">Nama</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-2 py-3">{{$dt->nama}}</td>
                    <td class="border px-2 py-3">{{$dt->nama}}</td>
                    <td class="border px-2 py-3">{{$dt->nama}}</td>
                </tr>
            </tbody>
        </table>
        <label for="" class="mb-2 font-bold">Progress: Pending</label>
        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
        </div>
    </div> -->
@endsection