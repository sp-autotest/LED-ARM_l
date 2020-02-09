<?php 

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Aeroport;
use App\User;
use App\Profile;
use Auth;
use Excel;
use DB;
use App\Classes\CurrencyManager;
use App\ReportTicket as Ticket;
use App\Order as Order;
use App\ReportService as Service;
use App\AdminCompany as Company;
use App\Exports\CompanyExport;
use App\Exports\PassengerExport;
use App\Exports\AeroportsExport;
use App\Exports\ServiceExport;
use App\Exports\MainExport;
use App\Http\Requests\CompanyExportRequest;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;



class APIReportsController extends Controller
{
	public $successStatus = 200;
	public $errorStatus = 400;





  public function index() {
        $this->middleware(['role_or_permission:reports.index']);
      

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['reports'] = 1;
         $companies = Company::all();

       return response()->json(['companies' => $companies, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);

  }

    public function getReport($id) {
    
      $company = Company::findOrFail($id);

       return response()->json(['company' => $company, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);
}



public function getEmailReport(Request $request) {
        $this->middleware(['role_or_permission:reports.to-excel']);

      $company_id = intval($request->company_id); 
      $start_date = date("Y-m-d",strtotime($request->start_date));
      $end_date =  date("Y-m-d", strtotime($request->end_date));
    
  $total = Company::where('id','=',$company_id)->count();

  if ($total > 0) {


      $company= Company::where('id','=',$company_id)->first();
      $company_name =$company->company_name;
     
      $reports = Order::with(['services'])
          ->where([
            ['orders.company_registry_id','=', $company_id],
            ['orders.created_at','>=',$start_date], 
            ['orders.created_at','<=',$end_date]
          ])
          ->whereHas('services', function($q){
            $q->where('service_status','=', 0)
              ->orWhere('service_status','=', 4)
              ->orWhere('service_status','=', 5)
              ->orWhere('service_status','=', 7);  
          })
          ->get();
        //  dd($reports);

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet()->setTitle('Отчет заказчика');
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(60);
      $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
      $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
      $spreadsheet->getActiveSheet()->getStyle('A10:O10')->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()->setARGB('FFE5CC');


      $sheet->setCellValue('F2', 'Отчет');
      $sheet->getStyle("F2")->getFont()->setSize(16);


      $sheet->setCellValue('A3', 'Компания  '.$company_name);
      $sheet->getStyle("A3")->getFont()->setSize(14);
      $sheet->setCellValue('A4', 'Период с: '.$start_date.'  Период по: '.$end_date);

      $sheet->getStyle("A4")->getFont()->setSize(14);
      $sheet->setCellValue('A5', 'По всем подчиненным организациям: нет');
      $sheet->getStyle("A5")->getFont()->setSize(14);



      $sheet->setCellValue('A9', 'Авиа');
      $sheet->getStyle("A9")->getFont()->setSize(16);


      $sheet->setCellValue('A10', 'Дата');
      $sheet->setCellValue('B10', 'Заказ');
      $sheet->setCellValue('C10', 'Услуга');
      $sheet->setCellValue('D10', 'Тип');
      $sheet->setCellValue('E10', 'Компания');
      $sheet->setCellValue('F10', 'Номер билета');
      $sheet->setCellValue('G10', 'Направление');
      $sheet->setCellValue('H10', 'Дата вылета');
      $sheet->setCellValue('I10', 'Пассажиры');
      $sheet->setCellValue('J10', 'Тариф');
      $sheet->setCellValue('K10', 'Таксы');
      $sheet->setCellValue('L10', 'Сборы заказчика');
      $sheet->setCellValue('M10', 'Брутто а/к');
      $sheet->setCellValue('N10', 'Цена билета для продажи');
      $sheet->setCellValue('O10', 'Комиссия');
      $rows = 11;
      $finalsumm = 0.0;
      $servicedist = [];
      foreach($reports as $report){

        $report = $report->toArray();
        foreach ($report['services'] as $key => $service) {
          # code...
        if($service['service_status'] == 0 || $service['service_status'] == 4 || $service['service_status'] == 5 || $service['service_status'] == 7  ){
          if(!in_array($report['id'], $servicedist)){
             $servicedist[] = $report['id'];
             $finalsumm += $report['order_summary'];
          }
        //dd($report);
      
        $sheet->setCellValue('A' . $rows, date("Y-m-d", strtotime($report['created_at'])));
        $sheet->setCellValue('B' . $rows, $report['order_n']);
        $sheet->setCellValue('C' . $rows, $service['service_id']);

        if ($service['service_status'] == 0 and $service['provider_id'] == 1) {
          $status="Возврат";
          $sheet->setCellValue('E' .$rows,  $status);
        }

        if ($service['service_status'] == 0 and $service['provider_id'] == 2) {
          $status="Возврат блок";
          $sheet->setCellValue('D' .$rows,  $status);
        }


        if ($service['service_status']  == 4 and $service['provider_id'] == 1) {
          $status="Обмен";
          $sheet->setCellValue('D' .$rows,  $status);
        }


        if ($service['service_status']  == 4 and $service['provider_id'] == 2) {
          $status="Обмен блок";
          $sheet->setCellValue('D' .$rows,  $status);
        }

        if ($service['service_status']  == 5 and $service['provider_id'] == 1) {
          $status="Продажа";
          $sheet->setCellValue('D' .$rows,  $status);

        }

        if ($service['service_status']  == 5 and $service['provider_id'] == 2) {
          $status="Продажа блок";
          $sheet->setCellValue('D' .$rows,  $status);

        }

        if($service['service_status']  == 7 and $service['provider_id'] == 1) {
          $status="Продажа crane";
          $sheet->setCellValue('D' .$rows, $status);
        }

   
        $sheet->setCellValue('E' . $rows, $report['company']['company_name']);
        $sheet->setCellValue('F' . $rows, $service['ticket']['ticket_number']);
        
        $sheet->setCellValue('G' . $rows, $service['flight']['flightplaces']['schedule'][0]['departure']['name_ru']."  ". "-"."  ". $service['flight']['flightplaces']['schedule'][count($service['flight']['flightplaces']['schedule'])-1]['arrival']['name_ru']);

        $sheet->setCellValue('H' . $rows, date("Y-m-d", strtotime($service['departure_date'])));
       /* if(!is_null($service['arrival_date'])){
          $sheet->setCellValue('I' . $rows,date("Y-m-d", strtotime($service['arrival_date'] )));
        }else{$sheet->setCellValue('I' . $rows, '');}
        */
        $sheet->setCellValue('I' . $rows, $service['passenger']['name']."   ".$service['passenger']['surname'] );
        $sheet->setCellValue('J' . $rows, $service['ticket']['rate_fare'] -$service['ticket']['tax_fare']);
        $sheet->setCellValue('K' . $rows, $service['ticket']['tax_fare']);
        $sheet->setCellValue('L' . $rows, $service['ticket']['types_fees_fare']);
        $sheet->setCellValue('M' . $rows, $service['ticket']['rate_fare']);
        $sheet->setCellValue('N' . $rows,  $service['ticket']['summ_ticket'] );
        $sheet->setCellValue('O' . $rows,  $service['ticket']['commission_fare'] );
        $rows++;
        }
        }
      }
       $sheet->setCellValue('N' . $rows, "Итого:" );
       $sheet->setCellValue('O' . $rows, $finalsumm );
       $date =  date('YmdHis');


    $filename = "reports".$date;
    $writer = new Xls($spreadsheet);
    header('Content-Type: application/vnd.ms-excel');
    $writer->save(storage_path("app/public/reports/".$filename.".xls"));
    header("Content-Type: application/vnd.ms-excel"); 
    $file = "/storage/reports/".$filename.".xls";
    return response()->json(['total' => $total, 'file'=>$file], $this->successStatus);   

  }else{
    $msg = "Нет данных в данном запросе";
    return response()->json(['total' => $total, 'msg'=>$msg], $this->successStatus);   
}


}






public function makeReport(Request $request) {
        $this->middleware(['role_or_permission:reports.create-report']);

  $company_id = intval($request->company_id); 
  $start_date =  date("Y-m-d", strtotime($request->start_date));
  $end_date =  date("Y-m-d", strtotime($request->end_date)); 

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $user_email =  Auth::user()->email;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['reports'] = 1;

  $total = Company::where('id','=',$company_id)->count();

  if ($total > 0) {

       $reports = Order::with(['services'])
          ->where([
            ['orders.company_registry_id','=', $company_id],
            ['orders.created_at','>=',$start_date], 
            ['orders.created_at','<=',$end_date]
          ])
          ->whereHas('services', function($q){
            $q->where('service_status','=', 0)
              ->orWhere('service_status','=', 4)
              ->orWhere('service_status','=', 5)
              ->orWhere('service_status','=', 7);  
          })
          ->get()->toArray();
      foreach($reports as $r=>$report){

       
        foreach ($report['services'] as $key => $service) {
          $reports[$r]['services'][$key]['direction'] = $service['flight']['flightplaces']['schedule'][0]['departure']['name_ru']."  ". "-"."  ". $service['flight']['flightplaces']['schedule'][count($service['flight']['flightplaces']['schedule'])-1]['arrival']['name_ru'];
           
             if ($service['service_status'] == 0 and $service['provider_id'] == 1) {
               $status="Возврат";
             }

            if ($service['service_status'] == 0 and $service['provider_id'] == 2) {
              $status="Возврат блок";
            }


            if ($service['service_status']  == 4 and $service['provider_id'] == 1) {
              $status="Обмен";
            }


            if ($service['service_status']  == 4 and $service['provider_id'] == 2) {
              $status="Обмен блок";
            }

            if ($service['service_status']  == 5 and $service['provider_id'] == 1) {
              $status="Продажа";
            }

            if ($service['service_status']  == 5 and $service['provider_id'] == 2) {
              $status="Продажа блок";
            }

            if($service['service_status']  == 7 and $service['provider_id'] == 1) {
              $status="Продажа crane";
            }
             $reports[$r]['services'][$key]['final_status'] = $status;

        }
      }
       return response()->json(['report' => $reports, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile,'user_email'=>$user_email ], $this->successStatus);
    }

  else {

  $msg = "No data according current request";


  return response()->json(['total' => $total, 'msg'=>$msg], $this->successStatus);   
     
  }


}


  public function postEmailReport(Request $request) {

        $this->middleware(['role_or_permission:reports.to-email']);

    $company_id = $request->company_id; 
    $start_date =  date("Y-m-d", strtotime($request->start_date));
    $end_date =  date("Y-m-d", strtotime($request->end_date)); 
      
      
    $user_email = $request->user_email;
    $added_email = $request->added_email;

        $total = Company::where('id','=',$company_id)->count();

    if ($total > 0) {


      $company= Company::where('id','=',$company_id)->first();
      $company_name =$company->company_name;


      $reports = Order::with(['services'])
          ->where([
            ['orders.company_registry_id','=', $company_id],
            ['orders.created_at','>=',$start_date], 
            ['orders.created_at','<=',$end_date]
          ])
          ->whereHas('services', function($q){
            $q->where('service_status','=', 0)
              ->orWhere('service_status','=', 4)
              ->orWhere('service_status','=', 5)
              ->orWhere('service_status','=', 7);  
          })
          ->get();
        //  dd($reports);

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet()->setTitle('Отчет заказчика');
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(60);
      $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
      $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
      $spreadsheet->getActiveSheet()->getStyle('A10:O10')->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()->setARGB('FFE5CC');


      $sheet->setCellValue('F2', 'Отчет');
      $sheet->getStyle("F2")->getFont()->setSize(16);


      $sheet->setCellValue('A3', 'Компания  '.$company_name);
      $sheet->getStyle("A3")->getFont()->setSize(14);
      $sheet->setCellValue('A4', 'Период с: '.$start_date.'  Период по: '.$end_date);

      $sheet->getStyle("A4")->getFont()->setSize(14);
      $sheet->setCellValue('A5', 'По всем подчиненным организациям: нет');
      $sheet->getStyle("A5")->getFont()->setSize(14);



      $sheet->setCellValue('A9', 'Авиа');
      $sheet->getStyle("A9")->getFont()->setSize(16);


      $sheet->setCellValue('A10', 'Дата');
      $sheet->setCellValue('B10', 'Заказ');
      $sheet->setCellValue('C10', 'Услуга');
      $sheet->setCellValue('D10', 'Тип');
      $sheet->setCellValue('E10', 'Компания');
      $sheet->setCellValue('F10', 'Номер билета');
      $sheet->setCellValue('G10', 'Направление');
      $sheet->setCellValue('H10', 'Дата вылета');
  //    $sheet->setCellValue('I10', 'Дата прилёта');
      $sheet->setCellValue('I10', 'Пассажиры');
      $sheet->setCellValue('J10', 'Тариф');
      $sheet->setCellValue('K10', 'Таксы');
      $sheet->setCellValue('L10', 'Сборы заказчика');
      $sheet->setCellValue('M10', 'Брутто а/к');
      $sheet->setCellValue('N10', 'Цена билета для продажи');
      $sheet->setCellValue('O10', 'Комиссия');
      $rows = 11;
      $finalsumm = 0.0;
      $servicedist = [];
      foreach($reports as $report){

        $report = $report->toArray();
        foreach ($report['services'] as $key => $service) {
          # code...
        if($service['service_status'] == 0 || $service['service_status'] == 4 || $service['service_status'] == 5 || $service['service_status'] == 7  ){
          if(!in_array($report['id'], $servicedist)){
             $servicedist[] = $report['id'];
             $finalsumm += $report['order_summary'];
          }
        //dd($report);
      
        $sheet->setCellValue('A' . $rows, date("Y-m-d", strtotime($report['created_at'])));
        $sheet->setCellValue('B' . $rows, $report['order_n']);
        $sheet->setCellValue('C' . $rows, $service['service_id']);

        if ($service['service_status'] == 0 and $service['provider_id'] == 1) {
          $status="Возврат";
          $sheet->setCellValue('E' .$rows,  $status);
        }

        if ($service['service_status'] == 0 and $service['provider_id'] == 2) {
          $status="Возврат блок";
          $sheet->setCellValue('D' .$rows,  $status);
        }


        if ($service['service_status']  == 4 and $service['provider_id'] == 1) {
          $status="Обмен";
          $sheet->setCellValue('D' .$rows,  $status);
        }


        if ($service['service_status']  == 4 and $service['provider_id'] == 2) {
          $status="Обмен блок";
          $sheet->setCellValue('D' .$rows,  $status);
        }

        if ($service['service_status']  == 5 and $service['provider_id'] == 1) {
          $status="Продажа";
          $sheet->setCellValue('D' .$rows,  $status);

        }

        if ($service['service_status']  == 5 and $service['provider_id'] == 2) {
          $status="Продажа блок";
          $sheet->setCellValue('D' .$rows,  $status);

        }

        if($service['service_status']  == 7 and $service['provider_id'] == 1) {
          $status="Продажа crane";
          $sheet->setCellValue('D' .$rows, $status);
        }

   
        $sheet->setCellValue('E' . $rows, $report['company']['company_name']);
        $sheet->setCellValue('F' . $rows, $service['ticket']['ticket_number']);
        
        $sheet->setCellValue('G' . $rows, $service['flight']['flightplaces']['schedule'][0]['departure']['name_ru']."  ". "-"."  ". $service['flight']['flightplaces']['schedule'][count($service['flight']['flightplaces']['schedule'])-1]['arrival']['name_ru']);

        $sheet->setCellValue('H' . $rows, date("Y-m-d", strtotime($service['departure_date'])));
       /* if(!is_null($service['arrival_date'])){
          $sheet->setCellValue('I' . $rows,date("Y-m-d", strtotime($service['arrival_date'] )));
        }else{$sheet->setCellValue('I' . $rows, '');}
        */
        $sheet->setCellValue('I' . $rows, $service['passenger']['name']."   ".$service['passenger']['surname'] );
        $sheet->setCellValue('J' . $rows, $service['ticket']['rate_fare'] -$service['ticket']['tax_fare']);
        $sheet->setCellValue('K' . $rows, $service['ticket']['tax_fare']);
        $sheet->setCellValue('L' . $rows, $service['ticket']['types_fees_fare']);
        $sheet->setCellValue('M' . $rows, $service['ticket']['rate_fare']);
        $sheet->setCellValue('N' . $rows,  $service['ticket']['summ_ticket'] );
        $sheet->setCellValue('O' . $rows,  $service['ticket']['commission_fare'] );
        $rows++;
        }
        }
      }
       $sheet->setCellValue('N' . $rows, "Итого:" );
      $sheet->setCellValue('O' . $rows, $finalsumm );
    $date =  date('YmdHis');


    $filename = "reports".$date;
    $writer = new Xls($spreadsheet);
    header('Content-Type: application/vnd.ms-excel');
    $writer->save(storage_path("app/public/reports/".$filename.".xls"));
    header("Content-Type: application/vnd.ms-excel"); 
    $file = storage_path("app/public/reports/".$filename.".xls");
      $data = [

      'filename' => $filename


    ];

    $email = Company::where('id','=', Auth::user()->company_id)->first()->report_mail;

    \Mail::send('emails.reports', $data, function($message) use ($email, $file)
    {

    $message->from(env("MAIL_FROM"));
    $message->to($email, $email);
    $message->attach($file);
    $message->subject('Отчет');
    });
    return response()->json(['total' => $total, 'status'=>'SUCCESS'], $this->successStatus);
    }else {

    $msg = "No data according current request";


    return response()->json(['total' => $total, 'status'=>'ERROR', 'msg'=>$msg], $this->successStatus);   
       
    }
  }
}






?>
