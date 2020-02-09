<?php

namespace App\Exports;

use App\User;
use App\ReportTicket as Ticket;
use App\ReportOrder as Order;
use App\ReportService as Service;
use App\ReportCompany as Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;


class CoreExport implements FromQuery
{



  use Exportable;



    public function __construct(int $date)
    {
       
        $this->date  = $date;
    }

   public function collection()
    {
       
     return Service::query()->where('created_at','=', $this->date);

    }

   