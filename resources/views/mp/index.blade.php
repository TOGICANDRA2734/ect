@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Tabel MP
        </h2>

        <form action="{{route('mp.index')}}" method="GET" class="grid grid-cols-2 sm:grid-cols-7 gap-4">
            <div class="sm:col-span-2">
                <label fo class="font-bold pb-1 text-xs md:text-sm" for="site">Nama Site</label>
                <select class="p-2 border border-gray-100 rounded-md w-full text-xs md:text-base" name="site" id="site">
                    <option value="" selected>Semua Site</option>

                    @foreach ($site as $st)
                        <option value="{{$st->kodesite}}" {{old('site', request()->site) == $st->kodesite ? 'selected' : ''}}>{{$st->namasite}} - {{$st->lokasi}}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="font-bold pb-1 text-xs md:text-sm" for="statusKaryawan">Stat. Karyawan</label>
                <select class="p-2 border border-gray-100 rounded-md w-full text-xs md:text-base" name="statusKaryawan" id="statusKaryawan">
                    <option value="">Semua</option>
                    <option value="STAFF">Staff</option>
                    <option value="NON STAFF">Non-Staff</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="font-bold pb-1 text-xs md:text-sm" for="statusKontrak">Stat. Kontrak</label>
                <select class="p-2 border border-gray-100 rounded-md w-full text-xs md:text-base" name="statusKontrak" id="statusKontrak">
                    <option value="">Semua</option>
                    <option value="habisKontrak">Kontrak Segera Habis</option>
                    <option value="masihKontrak">Dibawah Kontrak</option>
                </select>
            </div>

            <div class="relative py-2 px-4 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out flex justify-between items-center">
                <button>Proses</button>
                <a
                    class="align-middle flex justify-center items-center rounded-md focus:shadow-outline-purple focus:outline-none bg-stone-800 text-white hover:bg-gray-900 duration-150 ease-in-out"
                    @click="toggleConvertMenu"
                    @keydown.escape="closeConvertMenu"
                    aria-label="Account"
                    aria-haspopup="true"
                >
                    <svg class="h-6 w-6" viewBox="-2.5 -5 75 60" preserveAspectRatio="none">
                        <path d="M0,0 l35,50 l35,-50" fill="none" stroke="white" stroke-linecap="round" stroke-width="5" />
                    </svg>
                </a>
                <template x-if="isConvertMenuOpen">
                    <ul
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click.away="closeConvertMenu"
                    @keydown.escape="closeConvertMenu"
                    class="absolute z-50 right-0 top-16 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                    aria-label="submenu"
                    >
                        <li class="flex">
                            <form action="{{route('mp.export')}}" method="GET" class="w-full">
                                @foreach (request()->all() as $key => $values) 
                                    <input type="hidden" name="{{$key}}" id="{{$key}}" class="text-black w-7 text-xs" value="{{$values}}">
                                @endforeach
                                <button
                                    id="btPDF"
                                    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                >
                                    <svg
                                        class="w-4 h-4 mr-3"
                                        aria-hidden="true"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        ></path>
                                    </svg>
                                    <span>Excel</span>
                                </button>
                        </form>
                        </li>
                    </ul>
                </template>
            </div> 
        </form>

        <form class="flex justify-end mt-5" action="{{route('mp.index')}}" method="GET">
            <input name="nama" id="nama" type="text" placeholder="Cari data" class="p-2 rounded-md mr-3 w-full md:w-auto text-xs md:text-sm" autocomplete="off">
            <button
                class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-600 border border-transparent rounded-md active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple"
            >
                Cari
            </button>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Site</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">NIK</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Nama Karyawan</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Departemen</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Jabatan</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">No Kontak</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Usia</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Masa Kerja</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Detail</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $dt)
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                @foreach($dt as $key => $value)
                                    @if($key != 'nik')
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$value}} 
                                        </td>
                                    @endif
                                @endforeach
                                <td>
                                    <button @click="openModal2" value="{{$dt->nik}}" class="tbDetail px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-800 border border-transparent rounded-lg active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple">
                                        Detail
                                    </button>
                                </td>
                            </tr>                    
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-2 py-1 md:px-4 md:py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
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
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    $(document).ready(function(){
        // Search by userid
        $('.tbDetail').click(function(){
            var userid = $(this).val();
            
            if(userid >= 0){

                // AJAX POST request
                $.ajax({
                    url: '/tabel-mp/show',
                    type: 'post',
                    data: {_token: CSRF_TOKEN, userid: userid},
                    dataType: 'json',
                    success: function(response){
                        createRows(response);
                    }
                });
            }
        });
   });
 
   // Create table rows
    function createRows(response){
        var len = 0;
        $('#tablePersonal tbody').empty(); // Empty <tbody>
        $('#tableKerja tbody').empty(); // Empty <tbody>
        $('#modalImagePlaceholder div').empty(); // Empty <image>
        $("#modalDocsPlaceholder tbody").empty();
        $("#dataModal div").empty();
        if(response['data'] != null){
            len = response['data'].length;
        }
        
        var field_dismiss = ['id', 'foto1','foto2', 'ktp', 'time', 'user', 'del', 'sertifikasi', ]

        if(len > 0){
            for(var i=0; i<len; i++){
                // difference month
                // monthDifference(new Date(), new Date(response['data'][0].akhirpkwt)) 
                // response['data'][0].statuskary
                if(response['data'][0].statuskary == "PKWT"){
                    if(monthDifference(new Date(), new Date(response['data'][0].akhirpkwt)) <= 1){
                        var tr_modal = "<span class='px-2 py-1 text-xs md:text-base font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700'>" +
                            "Kontrak Segera Habis - " + dateConverter(response['data'][0].akhirpkwt) +
                        "</span>";        
                    } else {
                        var tr_modal = "<span class='px-2 py-1 text-xs md:text-base font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100'>" +
                            "Dibawah Kontrak"+
                        "</span>";        
                    }
                }
                else if (response['data'][0].statuskary == "PKWTT") {
                    if(monthDifference(new Date(), new Date(response['data'][0].tglpensiun)) <= 6){
                        var tr_modal = "<span class='px-2 py-1 text-xs md:text-base font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700'>" +
                            "Kontrak Segera Habis - " + dateConverter(response['data'][0].tglpensiun) +
                        "</span>";        
                    } else {
                        var tr_modal = "<span class='px-2 py-1 text-xs md:text-base font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100'>" +
                            "Dibawah Kontrak"+
                        "</span>";        
                    }
                }
                $("#dataModal div").append(tr_modal);

                var tr_str = 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-2 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>NIK</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].nik + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-2 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Nama</th>" + 
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].nama + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-2 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Tempat Lahir</th>" + 
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].tempatlahir + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Tanggal Lahir</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + dateConverter(response['data'][0].tgllahir) + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Umur</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + Math.floor((new Date() - new Date(response['data'][0].tgllahir)) / (365.25*24*60*60*1000)) + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Agama</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].agama + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Warga Negara</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].warganegara + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Status Nikah</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].statusnikah + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Pendidikan</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].pendidikan + "</td>" + 
                    "</tr>" +
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Ibu Kandung</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].ibukandung + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Kelamin</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].kelamin + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Gol. Darah</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].goldarah + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Rhesus</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].rhesus + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Nomor KTP</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].noktp + "</td>" + 
                    "</tr>" +
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>No KK</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].nokk + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>No NPWP</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].nonpwp + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>No BPJSTK</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].nobpjstk + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>No BPJSKES</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].nobpjskes + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>No Rek</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].norek + "</td>" + 
                    "</tr>" +
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>No Simpol</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].nosimpol + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Type Simpol</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].typesimpol + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Masa Simpol</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + dateConverter(response['data'][0].masasimpol) + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Alamat KTP</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].alamatktp + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Provinsi KTP</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].provktp + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Kabupaten KTP</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].kabktp + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Kecamatan KTP</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].kecktp + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Kelurahan KTP</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].kelktp + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Alamat</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].alamat + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Provinsi</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].prov + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Kabupaten</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].kab + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Kecamatan</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].kec + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Kelurahan</th>" +     
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].kelktp + "</td>" + 
                    "</tr>";
                $("#tablePersonal tbody").append(tr_str);

                // Data Pekerjaan
                var tr_str = 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Departemen</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].dept + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Jabatan</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].jabatan + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Status Pegawai</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].sttpegawai + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Golongan</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].gol + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+   
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Grade</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].grade + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Mulai Kerja</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + dateConverter(response['data'][0].mulaikerja) + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Status Karyawan</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].statuskary + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Akhir Kontrak</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + dateConverter(response['data'][0].akhirpkwt) + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Tanggal Pensiun</th>" +    
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + dateConverter(response['data'][0].tglpensiun) + "</td>" + 
                    "</tr>" +
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>No HP</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].hpkary + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Vaksin Covid-19</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].vaksin1 + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Email</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].emailkary + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Nama Istri</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].namaistri + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Nama Anak 1</th>" +    
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].namaanak1 + "</td>" + 
                    "</tr>" +
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Nama Anak 2</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].namaanak2 + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Nama Anak 3</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].namaanak3 + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Tinggal Serumah</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].tlpserumah + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Hubungan</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].hubkel + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Tidak Serumah</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].telptakrmh + "</td>" + 
                "</tr>" + 
                "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Hubungan</th>" +
                    "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].hubkel2 + "</td>" + 
                "</tr>";
                $("#tableKerja tbody").append(tr_str);


                // Foto Pengguna
                img_modal = "<img class='h-36 mr-3' src='http://192.168.20.100/manpower/"+ response['data'][0].foto1 +"' alt='Foto 1'>" 
                + "<img class='h-36 mr-3' src='http://192.168.20.100/manpower/"+ response['data'][0].foto2 +"' alt='Foto 2'>"
                + "<img class='h-36 mr-3' src='http://192.168.20.100/manpower/"+ response['data'][0].ktp +"' alt='Foto KTP'>";
                $("#modalImagePlaceholder div").append(img_modal);

                // Dokumen append
                dokumen_modal = 
                "<tr>" + 
                    "<td class='px-1 py-2 align-middle'>"+ response['dataDokumen'][0].judul +"</td>" +
                    "<td class='px-1 py-2 flex justify-center'>" + 
                        "<a href='http://192.168.20.100/manpower/" + response['dataDokumen'][0].link  + "'  target='_blank' class='bg-stone-800 p-1.5 text-white rounded-md font-bold uppercase'>Buka</a>" + 
                    "</td>" + 
                "</tr>";
                $("#modalDocsPlaceholder tbody").append(dokumen_modal);


            }
        }else{
            var tr_str = "<tr>" +
            "<td align='center' colspan='"+ response['data'][0][value].length +"'>No record found.</td>" +
            "</tr>";
    
            $("#tablePersonal tbody").append(tr_str);
        }
    }
    
    function dateConverter($value){
        var date = $value.split('-');
        return date[2] + '-' + date[1] + '-' + date[0];
    }

    function monthDifference(d1, d2){
        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth();
        months += d2.getMonth();
        return months;
    }
</script>
@endsection


@section('modal-body')
    <div id="dataModal" class="flex justify-between items-center">
        <h2 class="font-bold text-xl mb-3">Data Detail</h2>
        
        <div>
        </div>
    </div>
    
    <!-- Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="overflow-y-auto max-h-[30rem]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="w-full overflow-y-auto max-h-36 md:max-h-[20rem] mt-3 mb-3">
                    <h2 class="font-bold mb-2">Data Pribadi</h2>
                    <table id='tablePersonal' class="w-full whitespace-no-wrap border table-auto">
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        </tbody>
                    </table>
                </div>
                <div class="w-full overflow-y-auto max-h-36 md:max-h-[20rem] mt-3 mb-3">
                    <h2 class="font-bold mb-2">Data Kerja</h2>
                    <table id='tableKerja' class="w-full whitespace-no-wrap border table-auto">
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div id="modalImagePlaceholder">
                    <h2 class="font-bold mb-3">Foto</h2>
                    <div class="flex">
                    </div>
                </div>
                <div id="modalDocsPlaceholder">
                    <h2 class="font-bold mb-3">Dokumen</h2>
                    <div class="px-2">
                        <table class="w-full border text-xs">
                            <thead class="bg-stone-800 text-white">
                                <tr class="uppercase">
                                    <th class="px-1 py-2 align-middle">Nama Dokumen</th>
                                    <th class="px-1 py-2 align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection