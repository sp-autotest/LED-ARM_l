<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminCompany as Company;
use Auth;
use App\User;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Currency;
use App\Country;
use App\FeePlace;
use App\FareFamily;
use App\TypeFee;
use App\Airline;
use App\Aeroport;
use App\BCType;
use DB;



use App\Http\Requests\SearchFeePlaceRequest;
use App\Http\Requests\CopyFeePlaceRequest;
use App\Http\Requests\EditFeePlaceRequest;
use App\Http\Requests\AddFeePlaceRequest;
use App\Http\Requests\FeelPlaceCopyReplaceRequest;



class FeesPlacesController  extends Controller
{
   public $successStatus = 200;

    public function __construct()
    {
        $this->middleware('auth');
    }

  public function index() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile =Profile::where('user_id','=',$user_id)->first();
         $feesplaces = FeePlace::sortable()->paginate(10);
         $menuActiveItem['feesplaces'] = 1;
         $typefees =  TypeFee::paginate(10);
         $airlines = Airline::paginate(10);
         $airports = Aeroport::paginate(10);
         $farefamilies = FareFamily::paginate(10);


return response()->json(['feesplaces' => $feesplaces, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'typefees' => $typefees, 'airlines' => $airlines,  'farefamilies' => $farefamilies, 'airports' => $airports], $this->successStatus); 

        

 }


    public function search(SearchFeePlaceRequest $request) {

         $user = Auth::user();
         $user_id = Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $query = $request->get('query');
         $menuActiveItem['feesplaces'] = 1;
         $typefees =  TypeFee::paginate(10);
       $airports = Aeroport::paginate(10);
         $airlines = Airline::paginate(10);
         $farefamilies = FareFamily::paginate(10);
     
         
         $feesplaces_search  = DB::table('fees_places')
        ->join('fare_families', 'fees_places.fare_families_id', '=', 'fare_families.id')
        ->select('fees_places.*', 'fare_families.*')->where('fare_families.name_ru', 'like', '%'.$query.'%')->paginate(10); 
       

       $total = DB::table('fees_places')
        ->join('fare_families', 'fees_places.fare_families_id', '=', 'fare_families.id')
        ->select('fees_places.*', 'fare_families.*')->where('fare_families.name_ru', 'like', '%'.$query.'%')->count();
    
       if ($total > 0) {

       $fare =  FareFamily::where('name_ru','like', '%'.$query.'%')->first();
       $fare_id = intval ($fare->id);

       $feesplace = FeePlace::where('fare_families_id','=', $fare_id)->first();
       $feesplace_id = intval( $feesplace->id);

return response()->json(['feesplaces_search' => $feesplaces_search, 'total' => $total, 'profile' => $profile, 'query' => $query, 'menuActiveItem' => $menuActiveItem, 'typefees' => $typefees, 'airports' => $airports, 'airlines' => $airlines, 'feesplace_id' => $feesplace_id, 'farefamilies' => $farefamilies], $this->successStatus); 

        
    }
    
     else {

    return response()->json(['feesplaces_search' => $feesplaces_search, 'total' => $total, 'profile' => $profile, 'query' => $query, 'menuActiveItem' => $menuActiveItem], $this->successStatus); 

       

      }   	

    }



public function getFeePlaceEdit($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $feeplace = FeePlace::findOrFail($id);
         $companies =  Company::paginate(10);
         $typefees =  TypeFee::paginate(10);
         $countries = Country::paginate(10);
         $airlines = Airline::paginate(10);
         $farefamilies = FareFamily::all();
         $airports = Aeroport::paginate(10);
         $bc_types = BCType::paginate(10);
         $feesplaces = FeePlace::paginate(10);
        
         

 return view('feesplaces.feesplace-edit')->with('companies', $companies)->with('profile',$profile)->with('typefees',$typefees)->with('feeplace',$feeplace)->with('countries',$countries)->with('airlines', $airlines)->with('airoports', $airoports)->with('farefamilies',$farefamilies)->with('bc_types', $bc_types)->with('feesplaces',$feesplaces);

 }




public function getFeePlaceCopy($id) {
         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $fees = FeePlace::findOrFail($id);
         $typefees =  TypeFee::all();
         $menuActiveItem['feesplaces'] = 1;
         $airlines = Airline::paginate(10);
         $airoports = Aeroport::paginate(10);
         $farefamilies = FareFamily::paginate(10);
         $feesplaces = FeePlace::paginate(10);
         $bc_types = BCType::paginate(10);
         $companies =  Company::paginate(10);
     

 return view('feesplaces.feesplace-copy')->with('profile',$profile)->with('companies', $companies)->with('typefees',$typefees)->with('fees',$fees)->with('airlines', $airlines)->with('airoports', $airoports)->with('farefamilies',$farefamilies)->with('feesplaces',$feesplaces)->with('menuActiveItem', $menuActiveItem);

 }

    

public function getFeePlaceCopyReplace() {
         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $typefees =  TypeFee::all();
         $menuActiveItem['feesplaces'] = 1;
         $airlines = Airline::paginate(10);
         $airoports = Aeroport::paginate(10);
         $farefamilies = FareFamily::paginate(10);
         $feesplaces = FeePlace::paginate(10);
         $bc_types = BCType::paginate(10);
         $companies =  Company::paginate(10);
     

 return view('feesplaces.feesplace-copyreplace')->with('profile',$profile)->with('companies', $companies)->with('typefees',$typefees)->with('airlines', $airlines)->with('airoports', $airoports)->with('farefamilies',$farefamilies)->with('feesplaces',$feesplaces)->with('menuActiveItem', $menuActiveItem);

 }


    

public function getFeePlaceAdd() {
  
    $user = Auth::user();
    $user_id =  Auth::user()->id;
    $profile = Profile::where('user_id','=',$user_id)->first();
    $currencies =  Currency::paginate(10);
    $managers =  Profile::paginate(10);
    $companies =  Company::paginate(10);
    $typefees =  TypeFee::paginate(10);
    $countries = Country::paginate(10);
    $airlines = Airline::paginate(10);
    $airoports = Aeroport::paginate(10);
    $farefamilies = FareFamily::paginate(10);
    $bc_types = BCType::paginate(10);
    $feesplaces = FeePlace::paginate(10);


return view('feesplaces.feesplace-add')->with('companies', $companies)->with('profile',$profile)->with('typefees',$typefees)->with('countries',$countries)->with('airlines', $airlines)->with('airoports', $airoports)->with('farefamilies',$farefamilies)->with('bc_types', $bc_types)->with('feesplaces',$feesplaces);

}


public function postFeePlaceEdit(EditFeePlaceRequest $request) {
    
  
  $user_id =  Auth::user()->id;
  $user_email = Auth::user()->email;
  $feeplace_id = intval($request->get('feeplace_id'));
  $feeplace =  FeePlace::where( 'id', '=', $feeplace_id )->first();
  $feeplace->date_start =  Carbon::now();//$request->get('date_start');
  $feeplace->date_stop = Carbon::now();///$request->get('date_stop'); 
  $feeplace->company_id = intval($request->get('company_id'));
  $feeplace->period_begin_at= Carbon::now();//$request->get('period_begin_at'); 
  $feeplace->period_end_at= Carbon::now();//$request->get('period_end_at'); 
  $feeplace->airlines_id  = intval($request->get('airlines_id')); 
 // $feeplace->departure_city = $request->get('departure_city'); 
  //$feeplace->arrival_city = $request->get('arrival_city'); 
 /// $feeplace->type_action  = intval(1);//$request->get('type_action'); 
  $feeplace->non_return = intval($request->get('non_return')); 
  $feeplace->fare_families_id = intval($request->get('fare_families_id')); 
  $feeplace->fare_family_group = intval($request->get('fare_family_group')); 
  
  $feeplace->type_flight  = intval($request->get('type_flight')); 
  $feeplace->types_fees_id =  intval($request->get('types_fees_id'));
  $feeplace->infant  = $request->get('infant'); 
  $feeplace->country_id_departure=intval($request->get('country_id_departure')); 
  $feeplace->country_id_arrival  = intval($request->get('country_id_arrival')); 
  $feeplace->type_fees_inscribed  = intval($request->get('type_fees_inscribed')); 
  $feeplace->type_fees_charge  = intval($request->get('type_fees_charge')); 
  $feeplace->type_deviation  = intval($request->get('type_deviation')); 
  $feeplace->size_fees_exchange  = intval($request->get('size_fees_exchange')); 
  $feeplace->max_fees_inscribed  = intval($request->get('max_fees_inscribed')); 
  $feeplace->size_fees_inscribed  = intval($request->get('size_fees_inscribed')); 
  $feeplace->max_fees_inscribed  = intval($request->get('max_fees_inscribed'));
  $feeplace->min_fees_inscribed  = intval($request->get('min_fees_inscribed'));
  $feeplace->max_fees_charge  = intval($request->get('max_fees_charge')); 
  $feeplace->min_fees_charge  = intval($request->get('min_fees_charge')); 
  $feeplace->max_fees_exchange  = intval($request->get('max_fees_exchange')); 
  $feeplace->min_fees_exchange  = intval($request->get('min_fees_exchange')); 
  $feeplace->size_fees_exchange  = intval($request->get('size_fees_exchange')); 
  $feeplace->size_fees_charge  = intval($request->get('size_fees_charge')); 
  $feeplace->size_deviation  =intval($request->get('size_deviation')); 
  $feeplace->created_id=$user_id; 
  $feeplace->updated_id=$user_id; 
  $feeplace->created_at =  Carbon::now();
  $feeplace->save();

  
 $data = [

  'date_start' => $request->get('date_start'),
  'date_stop' => $request->get('date_stop'), 
  'period_begin_at'=> $request->get('period_begin_at'), 
  'airlines_id'  => $request->get('airlines_id'), 
  //'departure_city' => $request->get('departure_city'), 
 // 'arrival_city' => $request->get('arrival_city'), 
 // 'type_action'  => $request->get('type_action'), 
  'non_return' => $request->get('non_return'), 
  'fare_families_id' => $request->get('fare_families_id'), 
  'type_flight'  => $request->get('type_flight'), 
   'fare_families_group' => $request->get('fare_families_group'), 
  'infant'  => $request->get('infant'), 
  'country_id_departure' => $request->get('country_id_departure'), 
  'country_id_arrival'  => $request->get('country_id_arrival'), 
  'type_fees_inscribed'  => $request->get('type_fees_inscribed'), 
  'type_fees_charge'  => $request->get('type_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'max_fees_inscribed'  => $request->get('max_fees_inscribed'), 
  'max_fees_charge'  => $request->get('max_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'type_deviation'  => $request->get('type_deviation'), 
  'size_deviation'  => $request->get('size_deviation')


];
 


\Mail::send('emails.feeplace_add', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый сбор создан');
});


  return redirect('feesplaces');

 }




public function postFeePlaceCopyReplace(FeelPlaceCopyReplaceRequest  $request) {
  
  $user_id =  Auth::user()->id;
  $user_email = Auth::user()->email;

 
   $company_id1 = intval($request->get('company_id1'));
   $company_id2 = intval($request->get('company_id2'));


  

   $feesplaces1 = FeePlace::where('company_id','=',$company_id1)->get();

   $delfeesplaces2 = FeePlace::where('company_id','=',$company_id2)->delete();  

  
   FeePlace::insert($feesplaces1);
   


  
 $data = [

  'date_start' => $request->get('date_start'),
  'date_stop' => $request->get('date_stop'), 
  'period_begin_at'=> $request->get('period_begin_at'), 
  'airlines_id'  => $request->get('airlines_id'), 
 // 'departure_city' => $request->get('departure_city'), 
 // 'arrival_city' => $request->get('arrival_city'), 
  'type_action'  => $request->get('type_action'), 
  'non_return' => $request->get('non_return'), 
  'fare_families_id' => $request->get('fare_families_id'), 
  'type_flight'  => $request->get('type_flight'), 
  'infant'  => $request->get('infant'), 
  'country_id_departure' => $request->get('country_id_departure'), 
  'country_id_arrival'  => $request->get('country_id_arrival'), 
  'type_fees_inscribed'  => $request->get('type_fees_inscribed'), 
  'type_fees_charge'  => $request->get('type_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'max_fees_inscribed'  => $request->get('max_fees_inscribed'), 
  'max_fees_charge'  => $request->get('max_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'type_deviation'  => $request->get('type_deviation'), 
  'size_deviation'  => $request->get('size_deviation')


];
 


\Mail::send('emails.feeplace_copy', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый сбор скопирован с заменой');
});


  return redirect('feesplaces');

 }





public function postFeePlaceCopy(CopyFeePlaceRequest $request) {
    
  $uid=intval($request->get('uid'));
  $user_id =  Auth::user()->id;
  $user_email = Auth::user()->email;
  $feeplace =  new FeePlace;
  $feeplace->date_start =  Carbon::now();//$request->get('date_start');
  $feeplace->date_stop = Carbon::now();///$request->get('date_stop'); 
  $feeplace->company_id = intval($request->get('company_id'));
  $feeplace->period_begin_at= Carbon::now();//$request->get('period_begin_at'); 
  $feeplace->period_end_at= Carbon::now();//$request->get('period_end_at'); 
  $feeplace->airlines_id  = intval($request->get('airlines_id')); 
 // $feeplace->departure_city = $request->get('departure_city'); 
 // $feeplace->arrival_city = $request->get('arrival_city'); 
  //$feeplace->type_action  = intval(1);//$request->get('type_action'); 
  $feeplace->non_return = intval($request->get('non_return')); 
  $feeplace->fare_families_id = intval($request->get('fare_families_id')); 
  $feeplace->type_flight  = intval($request->get('type_flight')); 
  $feeplace->types_fees_id =  intval($request->get('types_fees_id'));
  //$feeplace->infant  = $request->get('infant'); 
  $feeplace->country_id_departure=intval($request->get('country_id_departure')); 
  $feeplace->country_id_arrival  = intval($request->get('country_id_arrival')); 
  $feeplace->type_fees_inscribed  = intval($request->get('type_fees_inscribed')); 
  $feeplace->type_fees_charge  = intval($request->get('type_fees_charge')); 
  $feeplace->type_deviation  = intval($request->get('type_deviation'));
   $feeplace->fare_family_group = intval($request->get('fare_family_group'));  
  $feeplace->size_fees_exchange  = intval($request->get('size_fees_exchange')); 
  $feeplace->max_fees_inscribed  = intval($request->get('max_fees_inscribed')); 
  $feeplace->size_fees_inscribed  = intval($request->get('size_fees_inscribed')); 
  $feeplace->max_fees_inscribed  = intval($request->get('max_fees_inscribed'));
  $feeplace->min_fees_inscribed  = intval($request->get('min_fees_inscribed'));
  $feeplace->max_fees_charge  = intval($request->get('max_fees_charge')); 
  $feeplace->min_fees_charge  = intval($request->get('min_fees_charge')); 
  $feeplace->max_fees_exchange  = intval($request->get('max_fees_exchange')); 
  $feeplace->min_fees_exchange  = intval($request->get('min_fees_exchange')); 
  $feeplace->size_fees_exchange  = intval($request->get('size_fees_exchange')); 
  $feeplace->size_fees_charge  = intval($request->get('size_fees_charge')); 
  $feeplace->size_deviation  =intval($request->get('size_deviation')); 
  $feeplace->created_id=$user_id; 
  $feeplace->updated_id=$user_id; 
  $feeplace->created_at =  Carbon::now();
  $feeplace->save();




  
 $data = [

  'date_start' => $request->get('date_start'),
  'date_stop' => $request->get('date_stop'), 
  'period_begin_at'=> $request->get('period_begin_at'), 
  'airlines_id'  => $request->get('airlines_id'), 
  //'departure_city' => $request->get('departure_city'), 
 // 'arrival_city' => $request->get('arrival_city'), 
  'type_action'  => $request->get('type_action'), 
  'non_return' => $request->get('non_return'), 
  'fare_families_id' => $request->get('fare_families_id'), 
  'type_flight'  => $request->get('type_flight'), 
  'infant'  => $request->get('infant'), 
  'country_id_departure' => $request->get('country_id_departure'), 
  'country_id_arrival'  => $request->get('country_id_arrival'), 
  'type_fees_inscribed'  => $request->get('type_fees_inscribed'), 
  'type_fees_charge'  => $request->get('type_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'max_fees_inscribed'  => $request->get('max_fees_inscribed'), 
  'max_fees_charge'  => $request->get('max_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'type_deviation'  => $request->get('type_deviation'), 
  'size_deviation'  => $request->get('size_deviation')


];
 


\Mail::send('emails.feeplace_copy', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый сбор скопирован');
});


  return redirect('feesplaces');

 }


 public function postFeePlaceAdd(AddFeePlaceRequest  $request) {


  $uid=intval($request->get('uid'));
  $user_id =  Auth::user()->id;
  $user_email = Auth::user()->email;
  $feeplace = new FeePlace;
  $feeplace->date_start =  Carbon::now();//$request->get('date_start');
  $feeplace->date_stop = Carbon::now();///$request->get('date_stop'); 
  $feeplace->company_id = intval($request->get('company_id'));
  $feeplace->period_begin_at= Carbon::now();//$request->get('period_begin_at'); 
  $feeplace->period_end_at= Carbon::now();//$request->get('period_end_at'); 
  $feeplace->airlines_id  = intval($request->get('airlines_id')); 
 // $feeplace->departure_city = $request->get('departure_city'); 
 // $feeplace->arrival_city = $request->get('arrival_city'); 
  //$feeplace->type_action  = intval(1);//$request->get('type_action'); 
  $feeplace->non_return = intval($request->get('non_return')); 
  $feeplace->fare_families_id = intval($request->get('fare_families_id')); 
  $feeplace->type_flight  = intval($request->get('type_flight')); 
  $feeplace->types_fees_id =  intval($request->get('types_fees_id'));
  $feeplace->infant  = $request->get('infant'); 
  $feeplace->country_id_departure=intval($request->get('country_id_departure')); 
  $feeplace->country_id_arrival  = intval($request->get('country_id_arrival')); 
  $feeplace->type_fees_inscribed  = intval($request->get('type_fees_inscribed')); 
  $feeplace->type_fees_charge  = intval($request->get('type_fees_charge')); 
  $feeplace->type_deviation  = intval($request->get('type_deviation'));
   $feeplace->fare_family_group = intval($request->get('fare_family_group'));  
  $feeplace->size_fees_exchange  = intval($request->get('size_fees_exchange')); 
  $feeplace->max_fees_inscribed  = intval($request->get('max_fees_inscribed')); 
  $feeplace->size_fees_inscribed  = intval($request->get('size_fees_inscribed')); 
  $feeplace->max_fees_inscribed  = intval($request->get('max_fees_inscribed'));
  $feeplace->min_fees_inscribed  = intval($request->get('min_fees_inscribed'));
  $feeplace->max_fees_charge  = intval($request->get('max_fees_charge')); 
  $feeplace->min_fees_charge  = intval($request->get('min_fees_charge')); 
  $feeplace->max_fees_exchange  = intval($request->get('max_fees_exchange')); 
  $feeplace->min_fees_exchange  = intval($request->get('min_fees_exchange')); 
  $feeplace->size_fees_exchange  = intval($request->get('size_fees_exchange')); 
  $feeplace->size_fees_charge  = intval($request->get('size_fees_charge')); 
  $feeplace->size_deviation  =intval($request->get('size_deviation')); 
  $feeplace->created_id=$user_id; 
  $feeplace->updated_id=$user_id; 
  $feeplace->created_at =  Carbon::now();
  $feeplace->save();


  $data = [

  'date_start' => $request->get('date_start'),
  'date_stop' => $request->get('date_stop'), 
  'period_begin_at'=> $request->get('period_begin_at'), 
  'airlines_id'  => $request->get('airlines_id'), 
 // 'departure_city' => $request->get('departure_city'), 
 // 'arrival_city' => $request->get('arrival_city'), 
  'type_action'  => $request->get('type_action'), 
  'non_return' => $request->get('non_return'), 
  'fare_families_id' => $request->get('fare_families_id'), 
  'fare_families_group' => $request->get('fare_families_group'), 
  'type_flight'  => $request->get('type_flight'), 
  'infant'  => $request->get('infant'), 
  'country_id_departure' => $request->get('country_id_departure'), 
  'country_id_arrival'  => $request->get('country_id_arrival'), 
  'type_fees_inscribed'  => $request->get('type_fees_inscribed'), 
  'type_fees_charge'  => $request->get('type_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'max_fees_inscribed'  => $request->get('max_fees_inscribed'), 
  'max_fees_charge'  => $request->get('max_fees_charge'), 
  'size_fees_exchange'  => $request->get('size_fees_exchange'), 
  'type_deviation'  => $request->get('type_deviation'), 
  'size_deviation'  => $request->get('size_deviation')


];
 


\Mail::send('emails.feeplace_add', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
//$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_email);
$message->subject('Новый сбор создан');
});


  return redirect('feesplaces');
 
  }
 










}
