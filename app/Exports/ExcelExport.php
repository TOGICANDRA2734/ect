<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings():array
    {
        return ['id', 'NIK', 'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'kelamin', 'KTP', 'Golongan Darah', 'rhesus', 'agama', 'Warga Negara', 'Status Nikah', 'Pendidikan', 'Ibu Kandung', 'Departement', 'Grade', 'Golongan', 'Jabatan', 'Tanggal Mulai Kerja', 'Status Karyawan', 'Akhir PKWT', 'PPJP PKWT', 'Tanggal Pensiun', 'Status PPH', 'Alamat KTP', 'Provinsi KTP', 'Kabupaten KTP', 'Kecamatan KTP', 'Kelurahan KTP', 'Status Rumah', 'Alamat', 'Provinsi', 'Kabupaten', 'Kecamatan', 'Kelurahan', 'No SIM', 'Tipe SIM', 'Masa SIM', 'No. KK', 'No. NPWP', 'No. Rek', 'No. BPJSTK', 'No. BPJSKES', 'Nama Istri', 'Nama Anak 1', 'Nama Anak 2', 'Nama Anak 3', 'No HP', 'Email', 'Telp Serumah (Emergency)', 'Hub Keluarga Serumah (Emergency)', 'Telp Tidak Serumah (Emergency)', 'Telp Tidak Serumah (Emergency)', 'Sertifikasi', 'vaksin', '', '', 'Keterangan', '', '', '', '', '', '', '', '', '', 'Status Pegawai'  ];
    }
}
