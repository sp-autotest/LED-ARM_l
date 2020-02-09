<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Image;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Mailing;
use App\MailingList;
use App\AdminCompany as Company;
use App\Order;


use  App\Http\Requests\MailingAddRequest;
use  App\Http\Requests\MailingEditRequest;
use  App\Http\Requests\MailListAddRequest;
use  App\Http\Requests\MailListEditRequest;
use  App\Http\Requests\CancelBookingRequest;
use  App\Http\Requests\ChangeMailingStatusRequest;
use  App\Http\Requests\DeleteMailRequest;
use  App\Http\Requests\AddMailRequest;



class APIMailingsController extends Controller
{
    
 
  public $successStatus = 200;
  public $errorStatus = '400';




  public function index(Request $request) {

         $companyid = (isset($request->company))?$request->company:Auth::user()->company_id;


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['mailing'] = 1;
         $mailings = Mailing::where('company_registry_id', '=', $companyid)->get()->toArray();
         $mailids = array_map(function($item){return $item['id'];},  Mailing::where('company_registry_id', '=', $companyid)->get()->toArray());
         $mailing_lists = MailingList::whereIn('mailing_id', $mailids)->get()->toArray();

       return response()->json(['mailings' => $mailings, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'mailing_lists'=>$mailing_lists,'user' => $user, 'profile' => $profile ], $this->successStatus);

  }
    public function getChild($data){

        $ids[] = $data['id'];

        if(count($data['childs']) > 0){
            foreach ($data['childs'] as $key => $value) {
                $ids = array_merge($ids, $this->getChild($value));
            }
        }
        return $ids;
    }

  public function addMailing() {


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['mailing'] = 1;
         $mailings = Mailing::all();
         $mailing_lists = MailingList::all();
         $companies = Company::all();

       return response()->json(['mailings' => $mailings,'mailing_lists'=>$mailing_lists,'companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);


  }  


public function postMailingAdd(MailingAddRequest $request) {
 
   $user = Auth::user();
   $user_id =  Auth::user()->id;
   $company_id = intval($request->get('company_id'));

   $mailing = new Mailing;
   $mailing->status = $request->status;
   $mailing->mail_list = $request->mail_list;
   $mailing->type_mailing=$request->type_mailing;
   $mailing->created_id = $user_id;
   $mailing->updated_id = $user_id;
   $mailing->company_registry_id= $company_id;
   $mailing->created_at =Carbon::now(); 
   $mailing->save();



 return response()->json(['mailing' => $mailing ], $this->successStatus);

}


public function getMailingEdit($id) {
 
   $user = Auth::user();
   $user_id =  Auth::user()->id;
   $profile = Profile::where('user_id','=',$user_id)->first();
   $mailing =  Mailing::findOrFail($id);
   $mailing_lists = MailingList::all();
   $companies = Company::all();

return response()->json(['mailing' => $mailing, 'mailing_lists'=>$mailing_lists,'companies' => $companies,'profile' => $profile,  'user' => $user, 'profile' => $profile ], $this->successStatus);


}

public function changeStatus(Request $request){

    $mailing =  Mailing::findOrFail($request->id);
    $mailing->status = !$mailing->status;
    $mailing->save();
    return response()->json(['mailing' => $mailing ],$this->successStatus);

}

public function postMailingEdit(MailingEditRequest $request) {
 
  
   $user = Auth::user();
   $user_id =  Auth::user()->id;
   $id = intval($request->get('id'));
   $company_id = intval($request->get('company_id'));

   $mailing =  Mailing::findOrFail($id);
   $mailing->status = $request->status;
   $mailing->mail_list = $request->mail_list;
   $mailing->type_mailing = $request->type_mailing;
   $mailing->created_id = $user_id;
   $mailing->updated_id = $user_id;
   $mailing->company_registry_id= $company_id;
   $mailing->updated_at =Carbon::now(); 
   $mailing->save();

return response()->json(['mailing' => $mailing ],$this->successStatus);



}


  public function addMailList() {


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['mailing'] = 1;
         $mailings = Mailing::all();
         $mailing_lists = MailingList::all();
         $companies = Company::all();

       return response()->json(['mailings' => $mailings,'mailing_lists'=>$mailing_lists,'companies' => $companies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus);


  }  





public function postAddEmail(Request $request)  {


     $email =$request->email;

     $m = Mailing::where('company_registry_id', '=', Auth::user()->company_id)->get();

     foreach ($m as $k=>$v){
         if($v->company_registry_id != Auth::user()->company_id){return response()->json(['error'=> 'mailing not found' ], $this->errorStatus);}
            $list = new MailingList;
            $list->mail = $email;
            $list->mailing_id = $v->id;
            $list->created_id = Auth::user()->id;
            $list->updated_id = Auth::user()->id;
            $list->save();
         $mailinglists[] = $list;
     }


  
return response()->json(['mailing_lists'=>$mailinglists ], $this->successStatus);



}




public function postDeleteEmail(Request $request)  {

 
 $email =$request->id;

 if(MailingList::where('id', '=', $email)->delete())
    return response()->json(['status' =>"true"], $this->successStatus);

 return response()->json(['status' =>"false" ], $this->errorStatus);



}




public function postMailListAdd(MailListAddRequest $request) {
 
   $user = Auth::user();
   $user_id =  Auth::user()->id;
   $mailing_id = intval($request->get('mailing_id'));
   $email = $request->get('email');

   $mail_list = new MailingList;
   $mail_list->mailing_id = $mailing_id;
   $mail_list->mail = $email;
   $mail_list->created_id = $user_id;
   $mail_list->updated_id = $user_id;
   $mail_list->created_at = Carbon::now(); 
   $mail_list->save();

  
 return response()->json(['mail_list' =>$mail_list ], $this->successStatus);



}



public static function AddCompanyMailing($company_id) {

   $user = Auth::user();
   $user_id =  Auth::user()->id;

   $status = true;

   $type_mailing1 =1;
   $type_mailing2 =2;
   $type_mailing3 =3;
   $type_mailing4 =4;
   $type_mailing5 =5;

   $mail_list1 = 1;
   $mail_list2 = 2;
   $mail_list3 = 3;
   $mail_list4 = 4;
   $mail_list5 = 5;


   $admin_email = $_ENV['MAIL_FROM'];


 $data_mailing  = [
            [
                'status' => $status,
                'mail_list' =>  $mail_list1,
                'type_mailing'=>$type_mailing1,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
              
            ],

            [
                'status' => $status,
                'mail_list' =>  $mail_list2,
                'type_mailing'=>$type_mailing2,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
            ],

            [
                'status' => $status,
                'mail_list' => $mail_list3,
                'type_mailing'=>$type_mailing3,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
            ],

            [
                'status' => $status,
                'mail_list' => $mail_list4,
                'type_mailing'=>$type_mailing4,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
            ],

            [
                'status' => $status,
                'mail_list' => $mail_list5,
                'type_mailing'=>$type_mailing5,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'company_registry_id'=>$company_id,
                'created_at' => Carbon::now(),
            ],
        ];

        Mailing::insert($data_mailing);

        $last_inserted_id = DB::getPdo()->lastInsertId();



for ($i= 0; $i<= $last_inserted_id; $i++) {


 $data_mailing_list  = [ 
             [
                'mailing_id'=>$i,
                'mail' =>  $admin_email,
                'created_id' =>$user_id,
                'updated_id' =>$user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              ]
            
        ];

        MailingList::insert($data_mailing_list);

   }

 return response()->json([ 'data_mailing'=>$data_mailing,'data_mailing_list'=>$data_mailing_list], self::successStatus);



}



public function getMailListEdit($id) {
 
   $user = Auth::user();
   $user_id =  Auth::user()->id;
   $profile = Profile::where('user_id','=',$user_id)->first();
   $mailing =  Mailing::all();
   $mailing_list = MailingList::findOrFail($id);
   $companies = Company::all();

return response()->json(['mailing' => $mailing, 'mailing_list'=>$mailing_list,'companies' => $companies,'profile' => $profile,  'user' => $user, 'profile' => $profile ], $this->successStatus);


}




public function changeMailStatus(ChangeMailingStatusRequest $request) {

 $status = $request->get('status');
 $company_id = intval($request->get('company_id'));

$mailing = Mailing::where('company_registry_id', '=', $company_id)->first();
$mailing->status=$status;
$mailing->save(); 

 return response()->json(['status' =>status], $this->successStatus);


}






public function postMailListEdit(MailListAddRequest $request) {
 
   $user = Auth::user();
   $user_id =  Auth::user()->id;
   $mailing_id = intval($request->get('mailing_id'));
   $id = intval($request->get('id'));
   $email = $request->get('email');
   $mail_list = MailingList::findOrFail($id);
   $mail_list->mailing_id = $mailing_id;
   $mail_list->mail = $email;
   $mail_list->created_id = $user_id;
   $mail_list->updated_id = $user_id;
   $mail_list->updated_at = Carbon::now(); 
   $mail_list->save();

  
 return response()->json(['mail_list' =>$mail_list ], $this->successStatus);



}




}
