<?php

namespace App\Exports;

use App\Calon_mahasiswa;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class CalonMahasiswaEmptyExport implements WithHeadings,ShouldAutoSize, WithEvents
{
	use Exportable;



    public function headings(): array
    {

    	$titles =  [
    		'NISN',
    		'NAMA',
    		'TANGGAL MASUK',
    		'PROGRAM STUDI',
    		'TAHUN MASUK',
    		'TEMPAT LAHIR',
    		'TANGGAL LAHIR',
    		'JENIS KELAMIN',
    		'AGAMA',
    		'ASAL SEKOLAH',
    		'ALAMAT',
    		'NO HP',
    		'EMAIL',
    	];

        $this->countTitles = count($titles);

        return $titles;
    }


    public function registerEvents(): array
    {

        return [
          AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:M1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }



}
