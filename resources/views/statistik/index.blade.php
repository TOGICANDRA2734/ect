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

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <div class="grid grid-cols-4 gap-5">
                    <div class="border-2 border-green-100">
                        <span class="text-xs">Data 1</span>
                        <table class="w-full table-auto text-sm">
                            <thead class="border border-red-100">
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>testing</td>
                                    <td>testing</td>
                                    <td class="text-center">95</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="border-2 border-green-100">
                        <span class="text-xs">Jabatan</span>
                        <table class="w-full table-auto text-sm">
                            <thead class="border border-red-100">
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>testing</td>
                                    <td>testing</td>
                                    <td class="text-center">95</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="border-2 border-green-100">
                        <span class="text-xs">Departemen</span>
                        <table class="w-full table-auto text-sm">
                            <thead class="border border-red-100">
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>testing</td>
                                    <td>testing</td>
                                    <td class="text-center">95</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="border-2 border-green-100">
                        <span class="text-xs">Alamat</span>
                        <table class="w-full table-auto text-sm">
                            <thead class="border border-red-100">
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>testing</td>
                                    <td>testing</td>
                                    <td class="text-center">95</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</main>

<script>
    function changeColor(el) {
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700');
        $(el).addClass('bg-gray-200', 'text-white');
    };
</script>
@endsection