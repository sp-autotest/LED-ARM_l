<?php

namespace App\Exports;

use App\Passenger;
use Maatwebsite\Excel\Concerns\FromCollection;

class PassengerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Passenger::all();
    }
}
