@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Tabel MP
        </h2>

        <form action="{{route('mp.index')}}" method="GET" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label fo class="font-bold pb-1 text-xs md:text-sm" for="site">Nama Site</label>
                <select class="p-2 border border-gray-100 rounded-md w-full text-xs md:text-base" name="site" id="site">
                    <option value="" selected>Semua Site</option>
                </select>
            </div>

            <div class="relative py-2 px-4 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out flex justify-between items-center">
                <button>Proses</button>
                <a class="align-middle flex justify-center items-center rounded-md focus:shadow-outline-purple focus:outline-none bg-stone-800 text-white hover:bg-gray-900 duration-150 ease-in-out" @click="toggleConvertMenu" @keydown.escape="closeConvertMenu" aria-label="Account" aria-haspopup="true">
                    <svg class="h-6 w-6" viewBox="-2.5 -5 75 60" preserveAspectRatio="none">
                        <path d="M0,0 l35,50 l35,-50" fill="none" stroke="white" stroke-linecap="round" stroke-width="5" />
                    </svg>
                </a>
                <template x-if="isConvertMenuOpen">
                    <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeConvertMenu" @keydown.escape="closeConvertMenu" class="absolute z-50 right-0 top-16 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                        <li class="flex">
                            <form action="{{route('mp.export')}}" method="GET" class="w-full">
                                <button id="btPDF" class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Excel</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </template>
            </div>
        </form>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-10">
            <div class="chart-container">
                <div class="pie-chart-container">
                    <canvas id="pie-chart"></canvas>
                </div>
            </div>
            <div id="columnchart_material" style="height: 20rem;"></div>
        </div>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <div class="">
                        <span class="text-sm pb-2 block font-semibold">Data 1</span>
                        <div class="overflow-y-scroll max-h-96 sm:max-h-[15rem]">
                            <table class="w-full table-auto text-sm">
                                <thead class="bg-stone-800 sticky top-0">
                                    <tr class="text-xs font-semibold tracking-wide text-center text-white capitalize dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Keterangan</th>
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Jumlah</th>
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">%</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Total Manpower
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->total}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->total/$data[0]->total * 100}}
                                        </td>
                                    </tr>
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Total Staff
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->Total_staff}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format($data[0]->Total_staff / ($data[0]->Total_staff + $data[0]->Total_non_staff) * 100, 1, ",", ".")}}
                                        </td>
                                    </tr>
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Total Non Staff
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->Total_non_staff}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format($data[0]->Total_non_staff / ($data[0]->Total_staff + $data[0]->Total_non_staff) * 100, 1, ",", ".")}}
                                        </td>
                                    </tr>
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Total Pria
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->Total_pria}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format($data[0]->Total_pria / ($data[0]->Total_pria + $data[0]->Total_perempuan) * 100, 1, ",", ".")}}
                                        </td>
                                    </tr>
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Total Wanita
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->Total_perempuan}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format($data[0]->Total_perempuan / ($data[0]->Total_pria + $data[0]->Total_perempuan) * 100, 1, ",", ".")}}
                                        </td>
                                    </tr>
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Umur Dibawah 20
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->dibawah20}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format(($data[0]->dibawah20 / ($data[0]->dibawah20 + $data[0]->diatas20 + $data[0]->diatas30 + $data[0]->diatas40 + $data[0]->diatas50 + $data[0]->diatas60) * 100),1, ",", ".")}}
                                        </td>
                                    </tr>
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Umur 20 - 30
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->diatas20}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format(($data[0]->diatas20 / ($data[0]->dibawah20 + $data[0]->diatas20 + $data[0]->diatas30 + $data[0]->diatas40 + $data[0]->diatas50 + $data[0]->diatas60) * 100),1, ",", ".")}}
                                        </td>
                                    </tr>
                                    
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Umur 30-40
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->diatas30}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format(($data[0]->diatas30 / ($data[0]->dibawah20 + $data[0]->diatas20 + $data[0]->diatas30 + $data[0]->diatas40 + $data[0]->diatas50 + $data[0]->diatas60) * 100),1, ",", ".")}}
                                        </td>
                                    </tr>
                                    
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Umur 40-50
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->diatas40}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format(($data[0]->diatas40 / ($data[0]->dibawah20 + $data[0]->diatas20 + $data[0]->diatas30 + $data[0]->diatas40 + $data[0]->diatas50 + $data[0]->diatas60) * 100),1, ",", ".")}}
                                        </td>
                                    </tr>
                                    
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Umur 50-60
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->diatas50}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format(($data[0]->diatas50 / ($data[0]->dibawah20 + $data[0]->diatas20 + $data[0]->diatas30 + $data[0]->diatas40 + $data[0]->diatas50 + $data[0]->diatas60) * 100),1, ",", ".")}}
                                        </td>
                                    </tr>
                                    
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            Umur 60++
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{$data[0]->diatas60}}
                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format(($data[0]->diatas60 / ($data[0]->dibawah20 + $data[0]->diatas20 + $data[0]->diatas30 + $data[0]->diatas40 + $data[0]->diatas50 + $data[0]->diatas60) * 100),1, ",", ".")}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="">
                        <span class="text-sm pb-2 block font-semibold">Jabatan</span>
                        <div class="overflow-y-scroll max-h-96 sm:max-h-[15rem]">
                            <table class="w-full table-auto text-sm">
                                <thead class="bg-stone-800 sticky top-0">
                                    <tr class="text-xs font-semibold tracking-wide text-center text-white capitalize dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Keterangan</th>
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Jumlah</th>
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">%</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    @foreach($jabatan as $jbt)
                                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        @foreach($jbt as $j)
                                            <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                                {{$j}}
                                            </td>
                                        @endforeach
                                        <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                            {{number_format($jbt->Jum / $sumJabatan * 100, 1, ",", ".")}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>      
                        </div>
                    </div>
                    <div class="">
                        <span class="text-sm pb-2 block font-semibold">Departemen</span>
                        <div class="overflow-y-scroll max-h-96 sm:max-h-[15rem]">
                            <table class="w-full table-auto text-sm">
                                <thead class="bg-stone-800 sticky top-0">
                                    <tr class="text-xs font-semibold tracking-wide text-center text-white capitalize dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Keterangan</th>
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Jumlah</th>
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">%</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    @foreach($dept as $departemen)
                                        <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                            @foreach($departemen as $j)
                                                <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                                    {{$j}}
                                                </td>
                                            @endforeach
                                            <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                                {{number_format($departemen->Jum / $sumJabatan * 100, 1, ",", ".")}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>    
                        </div>
                    </div>
                    <div class="">
                        <span class="text-sm pb-2 block font-semibold">Alamat</span>
                        <div class="overflow-y-scroll max-h-96 sm:max-h-[15rem]">        
                            <table class="w-full table-auto text-sm">
                                <thead class="bg-stone-800 sticky top-0">
                                    <tr class="text-xs font-semibold tracking-wide text-center text-white capitalize dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Keterangan</th>
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Jumlah</th>
                                        <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">%</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    @foreach($alamat as $al)
                                        <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                            @foreach($al as $j)
                                                <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                                    {{$j}}
                                                </td>
                                            @endforeach
                                            <td class="px-2 py-1 md:px-4 md:py-3 text-sm">
                                                {{number_format($al->Jum / $sumJabatan * 100, 1, ",", ".")}}
                                            </td>
                                        </tr>
                                    @endforeach    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<script>
  $(function(){
      //get the pie chart canvas
      var cData = JSON.parse(`<?php echo $dataPie['chart_data']; ?>`);
      var ctx = $("#pie-chart");
 
      //pie chart data
      var data = {
        labels: cData.label,
        datasets: [
          {
            label: "Users Count",
            data: cData.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          text: "Persebaran Tenaga Pekerja",
          fontSize: 18,
          fontColor: "#111"
        },
        legend: {
          display: true,
          position: "bottom",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        }
      };
 
      //create Pie Chart class object
      var chart1 = new Chart(ctx, {
        type: "pie",
        data: data,
        options: options
      });
 
  });
</script>
@endsection