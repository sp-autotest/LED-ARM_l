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
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MainExport implements FromQuery,WithHeadings,ShouldAutoSize

{


  use Exportable;



    public function __construct(int $company_id,  $start_date,  $end_date)
    {
        $this->company_id  = $company_id;
        $this->start_date =  date("Y-m-d", strtotime($start_date));
        $this->end_date =  date("Y-m-d", strtotime($end_date)); 

    }



   
       public function headings(): array
    {
        return [
            '№',
            'Дата',  'Заказ', 'Услуга',  'Тип', 'Компания',  'Номер билета', 'Направление', 'Дата с:', 'Дата по:',  'Пассажиры', 'Тариф', 'Таксы', 'Сборы заказчика', 'Брутто а/к', 'Цена билета для продажи'
        ];
    }



    /**
     * @return Builder
     */
    public function query()
    {
        return $report = Order::where('company_registry_id','=', $this->company_id)
        ->where('created_at','=',$this->start_date)
         ->orwhere('updated_at','=',$this->end_date)
    ->leftJoin('services', 'services.service_id', '=', 'orders.id')
    ->leftJoin('companies', 'companies.id', '=', 'orders.company_registry_id')
    ->leftJoin('tickets', 'tickets.passengers_id', '=', 'orders.passengers')
    ->leftJoin('passengers', 'tickets.passengers_id', '=', 'passengers.id')
     ->leftJoin('airports', 'services.arrival_at','=', 'airports.id')
     ->select('orders.created_at','orders.order_n','orders.id', 'companies.company_name','tickets.ticket_number','airports.name_ru','services.created_at','services.updated_at','passengers.name', 'passengers.surname','tickets.tax_fare','tickets.rate_fare','tickets.summ_ticket')->get();


}


}
