<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order;
use App\User;

use DB;
use App\Mailing;
use App\MailingList;


/**
 * Class SendNotify
 * @package App\Console\Commands
 */
class SendNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notify emails to users, if the orders expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

       $orders =  Order::where(\DB::raw("(created_at + time_limit * '1 second'::interval  - 1800 * '1 second'::interval)"), '>=', date('Y-m-d H:i:s') )->with([])->get();



 foreach($orders as $expired){
         

  $service_id =$expired->service_id;
  $order_created_at= $expired->order_created_at;


  $data = [

 
   'service_id' => $service_id,
   'order_created_at'=> $order_created_at,
    'order' => $expired


];

$company = User::where('id', '=', $expired->user_id)->first()->admincompany()->first();

     $mail_list = Mailing::where([[ 'company_registry_id', '=', $company->id], [ "type_mailing", '=', "5"], ['status', '=', true]])->get();


     foreach($mail_list as $mails) {

         $mail_list_id = $mails->id;


         $mailing_emails = MailingList::where('mailing_id', '=', $mail_list_id)->get();


         foreach ($mailing_emails as $mailing) {


             $mailing_email = $mailing->mail;

             \Mail::send('emails.mail_order_notify', $data, function ($message) use ($mailing_email) {
                 $message->from(env('MAIL_FROM'));
                 $message->to($mailing_email, $mailing_email);
                 $message->subject('Заказ будет анулирован');
             });

         }

     }

}

    
}

}