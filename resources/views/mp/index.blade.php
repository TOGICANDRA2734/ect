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
                <table class="w-full whitespace-no-wrap border">
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
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                @foreach($dt as $key => $value)
                                    @if($key != 'id')
                                        <td class="px-4 py-3 text-sm">
                                            {{$value}} 
                                        </td>
                                    @endif
                                @endforeach
                                <td>
                                    <button @click="openModal2" value="{{$dt->id}}" class="tbDetail px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-800 border border-transparent rounded-lg active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple">
                                        Detail
                                    </button>
                                </td>
                            </tr>                    
                        @endforeach
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
        if(response['data'] != null){
            len = response['data'].length;
        }
        
        var field_dismiss = ['id', 'foto1','foto2', 'ktp', 'time', 'user', 'del', 'sertifikasi', ]
    
        if(len > 0){
            for(var i=0; i<len; i++){
                var tr_str = "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].nik + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].nama + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].tempatlahir + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].tgllahir + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + Math.floor((new Date() - new Date(response['data'][0].tgllahir)) / (365.25*24*60*60*1000))   + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].agama + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].warganegara + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].statusnikah + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].pendidikan + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].ibukandung + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].kelamin + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].goldarah + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].rhesus+ "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].noktp + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].nokk + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].nonpwp + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].nobpjstk + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].nobpjskes + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].norek + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].nosimpol + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].typesimpol + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].masasimpol + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].alamatktp + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].provktp + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].kabktp + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].kecktp + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].kelktp + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].alamat + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].prov + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].kab + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].kec + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].kelktp + "</td>"
                "</tr>";
                $("#tablePersonal tbody").append(tr_str);

                // Data Pekerjaan
                var tr_str = "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].dept + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].jabatan + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].sttpegawai + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].gol + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].grade + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].mulaikerja + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].statuskary + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].akhirpkwt + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].tglpensiun + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].hpkary + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].vaksin1 + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].emailkary + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].namaistri + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].namaanak1 + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].namaanak2 + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].namaanak3 + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].tlpserumah + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].hubkel + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].telptakrmh + "</td>" +
                    "<td class='px-4 py-3 text-sm'>" + response['data'][0].hubkel2 + "</td>";
                    
                "</tr>";
                $("#tableKerja tbody").append(tr_str);


                // Foto Pengguna
                img_modal = "<img class='h-36 mr-3' src='http://192.168.20.100/manpower/"+ response['data'][0].foto1 +"' alt='Foto 1'>" 
                + "<img class='h-36 mr-3' src='http://192.168.20.100/manpower/"+ response['data'][0].foto2 +"' alt='Foto 2'>"
                + "<img class='h-36 mr-3' src='http://192.168.20.100/manpower/"+ response['data'][0].ktp +"' alt='Foto KTP'>";
                $("#modalImagePlaceholder div").append(img_modal);
            }
        }else{
            var tr_str = "<tr>" +
            "<td align='center' colspan='"+ response['data'][0][value].length +"'>No record found.</td>" +
            "</tr>";
    
            $("#tablePersonal tbody").append(tr_str);
        }

    } 
</script>
@endsection


@section('modal-body')
    <h2 class="font-bold text-xl mb-3">Data Detail</h2>
    
    <!-- Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto mt-3 mb-3">
            <h2 class="font-bold mb-2">Data Pribadi</h2>
            <table id='tablePersonal' class="w-full whitespace-no-wrap border table-auto">
                <thead class="bg-stone-800">
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 border-b border-r border-stone">NIK</th>
                        <th class="px-4 py-3 text-center border-r">Nama</th>
                        <th class="px-4 py-3 text-center border-r">Tempat Lahir</th>
                        <th class="px-4 py-3 text-center border-r">Tanggal Lahir</th>
                        <th class="px-4 py-3 text-center border-r">Umur</th>
                        <th class="px-4 py-3 border-b border-r border-stone">Agama</th>
                        <th class="px-4 py-3 border-b border-r border-stone">Warga Negara</th>
                        <th class="px-4 py-3 text-center border-r">Status Nikah</th>
                        <th class="px-4 py-3 text-center border-r">Pendidikan</th>
                        <th class="px-4 py-3 text-center border-r">Ibu Kandung</th>
                        <th class="px-4 py-3 text-center border-r">Kelamin</th>
                        <th class="px-4 py-3 text-center border-r">Gol. Darah</th>
                        <th class="px-4 py-3 text-center border-r">Rhesus</th>
                        <th class="px-4 py-3 text-center border-r">Nomor KTP</th>
                        <th class="px-4 py-3 text-center border-r">No KK</th>
                        <th class="px-4 py-3 text-center border-r">No NPWP</th>
                        <th class="px-4 py-3 text-center border-r">No BPJSTK</th>
                        <th class="px-4 py-3 text-center border-r">No BPJSKES</th>
                        <th class="px-4 py-3 text-center border-r">No Rek</th>
                        <th class="px-4 py-3 text-center border-r">No Simpol</th>
                        <th class="px-4 py-3 text-center border-r">Type Simpol</th>
                        <th class="px-4 py-3 text-center border-r">Masa Simpol</th>
                        <th class="px-4 py-3 text-center border-r">Alamat KTP</th>
                        <th class="px-4 py-3 text-center border-r">Provinsi KTP</th>
                        <th class="px-4 py-3 text-center border-r">Kabupaten KTP</th>
                        <th class="px-4 py-3 text-center border-r">Kecamatan KTP</th>
                        <th class="px-4 py-3 text-center border-r">Kelurahan KTP</th>
                        <th class="px-4 py-3 text-center border-r">Alamat</th>
                        <th class="px-4 py-3 text-center border-r">Provinsi</th>
                        <th class="px-4 py-3 text-center border-r">Kabupaten</th>
                        <th class="px-4 py-3 text-center border-r">Kecamatan</th>
                        <th class="px-4 py-3 text-center border-r">Kelurahan</th>

                        <!-- <th class="px-4 py-3 text-center border-r">Dept.</th>
                        <th class="px-4 py-3 text-center border-r">Grade</th>
                        <th class="px-4 py-3 text-center border-r">Golongan</th>
                        <th class="px-4 py-3 text-center border-r">Jabatan</th>
                        <th class="px-4 py-3 text-center border-r">Mulai Kerja</th>
                        <th class="px-4 py-3 text-center border-r">Status Karyawan</th>
                        <th class="px-4 py-3 text-center border-r">Akhir Kontrak</th>
                        <th class="px-4 py-3 text-center border-r">PPJPPKWT</th>
                        <th class="px-4 py-3 text-center border-r">Tanggal Pensiun</th>
                        <th class="px-4 py-3 text-center border-r">Status PPH</th>
                        <th class="px-4 py-3 text-center border-r">Ibu Kandung</th>
                        <th class="px-4 py-3 text-center border-r">Status Rumah</th>
                        <th class="px-4 py-3 text-center border-r">Nama Istri</th>
                        <th class="px-4 py-3 text-center border-r">Nama anak 1</th>
                        <th class="px-4 py-3 text-center border-r">Nama anak 2</th>
                        <th class="px-4 py-3 text-center border-r">Nama anak 3</th>
                        <th class="px-4 py-3 text-center border-r">No HP</th>
                        <th class="px-4 py-3 text-center border-r">Email</th>
                        <th class="px-4 py-3 text-center border-r">Telp. Rumah</th>
                        <th class="px-4 py-3 text-center border-r">Hubungan Kel</th>
                        <th class="px-4 py-3 text-center border-r">TelpTaRumah</th>
                        <th class="px-4 py-3 text-center border-r">HubKel12</th>
                        <th class="px-4 py-3 text-center border-r">Sertifikasi</th>
                        <th class="px-4 py-3 text-center border-r">Vaksin 1</th>
                        <th class="px-4 py-3 text-center border-r">Vaksin 2</th>
                        <th class="px-4 py-3 text-center border-r">Booster</th>
                        <th class="px-4 py-3 text-center border-r">Keterangan</th>
                        <th class="px-4 py-3 text-center border-r">Site</th>
                        <th class="px-4 py-3 text-center border-r">Kode Site</th>
                        <th class="px-4 py-3 text-center border-r">Status Pegawai</th> -->
                    </tr>
                </thead>

                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                </tbody>
            </table>
        </div>
        <div class="w-full overflow-x-auto mt-3 mb-3">
            <h2 class="font-bold mb-2">Data Kerja</h2>
            <table id='tableKerja' class="w-full whitespace-no-wrap border table-auto">
                <thead class="bg-stone-800">
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 text-center border-r">Departemen</th>
                        <th class="px-4 py-3 text-center border-r">Jabatan</th>
                        <th class="px-4 py-3 text-center border-r">Status Pegawai</th>
                        <th class="px-4 py-3 text-center border-r">Golongan</th>
                        <th class="px-4 py-3 text-center border-r">Grade</th>
                        <th class="px-4 py-3 text-center border-r">Mulai Kerja</th>
                        <th class="px-4 py-3 text-center border-r">Status Karyawan</th>
                        <th class="px-4 py-3 text-center border-r">Akhir Kontrak</th>
                        <th class="px-4 py-3 text-center border-r">Tanggal Pensiun</th>
                        <th class="px-4 py-3 text-center border-r">No HP</th>
                        <th class="px-4 py-3 text-center border-r">Vaksin Covid-19</th>
                        <th class="px-4 py-3 text-center border-r">Email</th>
                        <th class="px-4 py-3 text-center border-r">Nama Istri</th>
                        <th class="px-4 py-3 text-center border-r">Nama Anak 1</th>
                        <th class="px-4 py-3 text-center border-r">Nama Anak 2</th>
                        <th class="px-4 py-3 text-center border-r">Nama Anak 3</th>
                        <th class="px-4 py-3 text-center border-r">Tinggal Serumah</th>
                        <th class="px-4 py-3 text-center border-r">Hubungan</th>
                        <th class="px-4 py-3 text-center border-r">Tidak Serumah</th>
                        <th class="px-4 py-3 text-center border-r">Hubungan</th>
                        <!-- <th class="px-4 py-3 text-center border-r">PPJPPKWT</th>
                        <th class="px-4 py-3 text-center border-r">Status PPH</th>
                        <th class="px-4 py-3 text-center border-r">Ibu Kandung</th>
                        <th class="px-4 py-3 text-center border-r">HubKel12</th>
                        <th class="px-4 py-3 text-center border-r">Sertifikasi</th>
                        <th class="px-4 py-3 text-center border-r">Keterangan</th>
                        <th class="px-4 py-3 text-center border-r">Status Pegawai</th>
                        <th class="px-4 py-3 text-center border-r">Site</th> -->
                    </tr>
                </thead>

                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2">
            <div id="modalImagePlaceholder">
                <h2 class="font-bold mb-3">Foto</h2>
                <div class="flex">
                </div>
            </div>
            <div id="modalDocsPlaceholder">
                <h2 class="font-bold mb-3">Dokumen</h2>
                <div class="flex">
                </div>
            </div>
        </div>
    </div>
@endsection