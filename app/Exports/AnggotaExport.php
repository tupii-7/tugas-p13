<?php

namespace App\Exports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnggotaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * Get collection of anggota data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Anggota::select([
            'kode_anggota',
            'nama',
            'email',
            'telepon',
            'alamat',
            'tanggal_lahir',
            'jenis_kelamin',
            'pekerjaan',
            'tanggal_daftar',
            'status',
        ])->orderBy('created_at', 'desc')->get();
    }

    /**
     * Define Excel headings.
     *
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'Kode Anggota',
            'Nama',
            'Email',
            'Telepon',
            'Alamat',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Pekerjaan',
            'Tanggal Daftar',
            'Status',
        ];
    }
}
