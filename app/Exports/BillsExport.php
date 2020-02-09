<?php

namespace App\Exports;

use App\Bill;
use Maatwebsite\Excel\Concerns\FromCollection;

class BillsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bill::all();
    }
}
