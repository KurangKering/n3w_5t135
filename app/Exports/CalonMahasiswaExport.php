<?php

namespace App\Exports;

use App\Calon_mahasiswa;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
class CalonMahasiswaExport implements WithHeadings,ShouldAutoSize, FromQuery, WithStrictNullComparison,WithEvents
{
	use Exportable;



	public function query()
	{
		$columns = [
			'nisn',
			'nama',
			
		];
		return Calon_mahasiswa::query()->select($columns)->where('status', '0');
	}

	public function headings(): array
	{
		return [
			'NISN',
			'NAMA',
			'NIM',
			
		];
	}
	public function registerEvents(): array
	{
		return [
			AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:C1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }


}
