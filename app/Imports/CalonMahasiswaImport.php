<?php

namespace App\Imports;

use App\Calon_mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
class CalonMahasiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Calon_mahasiswa([
            //
        ]);
    }
}
