@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Distribusi Jam TP
        </h2>

        <!-- Filter -->
        <form action="{{route('distribusi-jam-tp.index')}}" method="GET" class="grid grid-cols-4 gap-4">
            <!-- Bulan -->
            <div class="">
                <label class="font-bold pb-1 text-sm" for="bulan">Tanggal Mulai</label>
                <input value="{{ request()->bulan == null ? date('Y-m') : old('bulan', request()->bulan)}}" type="month" name="bulan" id="bulan" class="p-2 border border-gray-100 rounded-md w-full">
            </div>

            <div class="">
                <label fo class="font-bold pb-1 text-sm"r="site">Nama Site</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="site" id="site">
                    <option value="" selected>Semua Site</option>

                    @foreach ($site as $st)
                        <option value="{{$st->kodesite}}" {{old('site', request()->site) == $st->kodesite ? 'selected' : ''}}>{{$st->namasite}} - {{$st->lokasi}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-bold pb-1 text-sm" for="jenisTampilan">Tampilkan Total Per Unit</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="jenisTampilan" id="jenisTampilan">
                    <option value="0" selected>Jangan Tampilkan</option>
                    <option value="1">Tampilkan</option>
                </select>
            </div>
            <div class="flex w-full relative">
                <button class="w-4/6 p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Cari</button>

                <a
                    class="w-2/6 align-middle flex justify-center items-center rounded-md focus:shadow-outline-purple focus:outline-none bg-stone-800 text-white hover:bg-gray-900 duration-150 ease-in-out"
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
                    class="absolute right-0 top-16 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                    aria-label="submenu"
                    >
                        <li class="flex">
                            <a
                            class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                            href="#"
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
                            <span>PDF</span>
                            </a>
                        </li>
                        <li class="flex">
                            <a
                            class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                            href="#"
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
                            </a>
                        </li>
                    </ul>
                </template>
            </div>            
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto" style="max-height: 36rem;">
                <table class="w-full whitespace-no-wrap border table-auto">
                    <thead class="bg-stone-800">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone w-20">No</th>
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone">No Unit</th>
                            <th colspan="7" class="px-4 py-3 text-center border-r">Working Hours</th>
                            <th rowspan="2" class="px-4 py-3 text-center border-r">BD</th>
                            <th colspan="19" class="px-4 py-3 text-center border-r">STB</th>
                            <th rowspan="2" class="px-4 py-3 text-center border-r">MOHH</th>
                            <th rowspan="2" class="px-4 py-3 text-center border-r">MA</th>
                            <th rowspan="2" class="px-4 py-3 text-center border-none">UTIL</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">OB</th>
                            <th class="px-4 py-3 border">ROOM</th>
                            <th class="px-4 py-3 border">PORT</th>
                            <th class="px-4 py-3 border">TRAV</th>
                            <th class="px-4 py-3 border">GEN</th>
                            <th class="px-4 py-3 border">RENT</th>
                            <th class="px-4 py-3 border">TOTAL</th>
                            @for($i=0; $i<=17; $i++)
                                <th class="px-4 py-3 border">S{{$i+1}}</th>
                            @endfor
                            <th class="px-4 py-3 border">TOTAL</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $key => $values)
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 border">{{$key+1}}</td>
                                <td class="px-4 py-3 border">
                                    {{$values->NOM_UNIT}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->OB, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->ROOM, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->POR, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->TRAV, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->GEN, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->RENT, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->TOTAL, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->BD, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S00, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S01, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S02, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S03, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S04, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S05, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S06, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S07, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S08, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S09, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S10, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S11, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S12, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S13, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S14, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S15, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S16, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S17, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->STB, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->MOHH, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->MA, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->UT, 1)}}
                                </td>
                            </tr>
                            @if(request()->jenisTampilan != 0)
                                @if(isset(($data[$key + 1])))
                                    @php 
                                        $nextRow = $data[$key + 1]
                                    @endphp

                                    @if(substr($values->NOM_UNIT,0,2) != substr($nextRow->NOM_UNIT,0,2))
                                        <tr class="data-row text-center text-gray-700 bg-gray-300 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                            <td class="px-4 py-3 text-sm" colspan="2">Total Unit</td>
                                            @php
                                                $hasilFilter = $filter->filter(function($item, $key) use ($values){
                                                    return in_array($key, [substr($values->NOM_UNIT,0,2)]);
                                                });
                                            @endphp
                                            @foreach($hasilFilter as $ft)
                                            <td colspan="2" class="px-4 py-3 border">Sub Total</td>
                                            <td class="px-4 py-3 border">
                                                {{$values->NOM_UNIT}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->OB, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->ROOM, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->POR, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->TRAV, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->GEN, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->RENT, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->TOTAL, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->BD, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S00, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S01, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S02, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S03, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S04, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S05, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S06, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S07, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S08, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S09, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S10, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S11, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S12, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S13, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S14, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S15, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S16, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S17, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->STB, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->MOHH, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->MA, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->UT, 1)}}
                                            </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @elseif($key == count($data)-1)
                                    <tr class="data-row text-center text-gray-700 bg-gray-300 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-4 py-3 text-sm" colspan="2">Total Unit</td>
                                        @php
                                            $hasilFilter = $filter->filter(function($item, $key) use ($values){
                                                return in_array($key, [substr($values->NOM_UNIT,0,2)]);
                                            });
                                        @endphp
                                        @foreach($hasilFilter as $ft)
                                            <td class="px-4 py-3 border">Sub Total</td>
                                            <td class="px-4 py-3 border">
                                                {{$values->NOM_UNIT}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->OB, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->ROOM, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->POR, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->TRAV, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->GEN, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->RENT, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->TOTAL, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->BD, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S00, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S01, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S02, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S03, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S04, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S05, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S06, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S07, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S08, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S09, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S10, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S11, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S12, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S13, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S14, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S15, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S16, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->S17, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->STB, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->MOHH, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->MA, 1)}}
                                            </td>
                                            <td class="px-4 py-3 border">
                                                {{number_format($values->UT, 1)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(request()->jenisTampilan == 0)
                <div class="px-4 py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
                    {{$data->links()}}
                </div>
            @endif
        </div>
</main>

<script>
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700')
        $(el).addClass('bg-gray-200', 'text-white')
    }
</script>
@endsection