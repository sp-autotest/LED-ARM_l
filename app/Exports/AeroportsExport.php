<?php

namespace App\Exports;

use App\Aeroport;
use Maatwebsite\Excel\Concerns\FromCollection;

class AeroportsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Aeroport::all();
    }
}
