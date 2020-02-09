<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\AdminCompany as Company;
use Auth;
use App\User;
use Image;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Currency;
use App\FareFamily;
use App\TypeFee;
use App\Airline;
use App\Aeroport;
use App\BCType;
use App\Passenger;
use App\Provider;
use App\Country;
use App\City;
use App\ProviderAccount;


use  App\Http\Requests\SearchCurrencyRequest;
use  App\Http\Requests\SearchAirlineRequest;
use  App\Http\Requests\SearchFareFamilyRequest;
use  App\Http\Requests\SearchPassengerRequest;
use  App\Http\Requests\SearchAeroportRequest;
use  App\Http\Requests\SearchBCTypeRequest;
use  App\Http\Requests\SearchProviderRequest;
use  App\Http\Requests\CurrencyAddRequest;
use  App\Http\Requests\AirlineAddRequest;
use  App\Http\Requests\ProviderAddRequest;
use  App\Http\Requests\FareFamilyAddRequest;
use  App\Http\Requests\FareFamilyEditRequest;
use  App\Http\Requests\PassengerAddRequest;
use  App\Http\Requests\PassengerEditRequest; 
use  App\Http\Requests\CurrencyEditRequest;  
use  App\Http\Requests\AirlineEditRequest;
use  App\Http\Requests\ProviderEditRequest;
use  App\Http\Requests\TypeFeeAddRequest;
use  App\Http\Requests\TypeFeeEditRequest;
use  App\Http\Requests\BCTypeAddRequest;
use  App\Http\Requests\BCTypeEditRequest;
use  App\Http\Requests\AiroportAddRequest;
use  App\Http\Requests\AiroportEditRequest;
use  App\Http\Requests\ProviderAccountEditRequest;
use  App\Http\Requests\ProviderAccountAddRequest;
use  App\Http\Requests\AddCountryRequest;
use  App\Http\Requests\EditCountryRequest;
use  App\Http\Requests\AddCityRequest;
use  App\Http\Requests\EditCityRequest;







class APIHandsBooksController extends Controller
{
   

    public $successStatus = 200;
    public $errorStatus = 400;

  




  public function index() {


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['currencies'] = 1;
         $currencies = Currency::all();


       return response()->json(['currencies' => $currencies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function addCurrency() {


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['currencies'] = 1;
         $currencies = Currency::all();


       return response()->json(['currencies' => $currencies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }  


public function postCurrencyAdd(CurrencyAddRequest $request) {
 

   $currency = new Currency;
   $currency->name_eng = $request->name_eng;
   $currency->name_ru = $request->name_ru;
   $currency->code_literal_iso_4217 = $request->code_literal_iso_4217;
   $currency->code_numeric_iso_4217 = $request->code_numeric_iso_4217;
   $currency->created_at = Carbon::now(); 
   $currency->save();



  return response()->json(['currency' => $currency], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}



public function postCurrencyEdit(CurrencyEditRequest $request) {
 

   $id = intval($request->get('id'));
   $currency = Currency::findOrFail($id);
   $currency->name_eng = $request->name_eng;
   $currency->name_ru = $request->name_ru;
   $currency->code_literal_iso_4217 = $request->code_literal_iso_4217;
   $currency->code_numeric_iso_4217 = $request->code_numeric_iso_4217;
   $currency->updated_at = Carbon::now(); 
   $currency->save();



  return response()->json(['currency' => $currency], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}


   public function searchCurrency(SearchAirlineRequest  $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['currency'] = 1;

        $query = $request->get('query');
        $search_currency = Currency::where('name_ru', 'LIKE', "%$query%")->all();

        $total = Currency::where('name_ru', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
          return response()->json(['search_currency' => $search_currency, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     
       }
       

       else {

        return response()->json([ 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

       }  

    }



public function postAirlineAdd(AirlineAddRequest $request) {

   $airline = new Airline;
   $airline->code_tkp = $request->code_tkp;
   $airline->aviacompany_name_ru = $request->aviacompany_name_ru;
   $airline->short_aviacompany_name_ru = $request->short_aviacompany_name_ru;
   $airline->short_aviacompany_name_eng = $request->short_aviacompany_name_eng;
   $airline->aviacompany_name_eng = $request->aviacompany_name_eng;
   $airline->code_iata = $request->code_iata;
   $airline->account_code_iata = $request->account_code_iata;
   $airline->account_code_tkp = $request->account_code_tkp;
   $airline->city_id = $request->city_id;

   $airline->date_begin_at = $request->date_begin_at;
   $airline->date_end_at = $request->date_end_at;
   $airline->created_at = Carbon::now(); 
   $airline->save();


  return response()->json(['airline' => $airline], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}



public function postAirlineEdit(AirlineEditRequest $request) {

   $id = intval($request->get('id'));
   $airline = Airline::findOrFail($id);
   $airline->code_tkp = $request->code_tkp;
   $airline->aviacompany_name_ru = $request->aviacompany_name_ru;
   $airline->short_aviacompany_name_ru = $request->short_aviacompany_name_ru;
   $airline->short_aviacompany_name_eng = $request->short_aviacompany_name_eng;
   $airline->aviacompany_name_eng = $request->aviacompany_name_eng;
   $airline->code_iata = $request->code_iata;
   $airline->account_code_iata = $request->account_code_iata;
   $airline->account_code_tkp = $request->account_code_tkp;
   $airline->city_id = $request->city_id;
   $airline->date_begin_at = $request->date_begin_at;
   $airline->date_end_at = $request->date_end_at;
   $airline->updated_at = Carbon::now(); 
   $airline->save();



  return response()->json(['airline' => $airline], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
; 

}




   public function searchAirline(SearchAirlineRequest $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['airlines'] = 1;
        $query = $request->get('query');
        $search_airline = Airline::where('aviacompany_name_ru', 'LIKE', "%$query%")->all();

        $total = Airline::where('aviacompany_name_ru', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
         return response()->json(['search_airline' => $search_airline, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     
     
       }
       

       else {

      return response()->json(['profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     

       }  



    }



  public function postFareFamilyAdd(FareFamilyAddRequest $request) {
 
   $farefamily = new FareFamily;
   $farefamily->code = $request->code;
   $farefamily->name_ru = $request->name_ru;
   $farefamily->name_eng = $request->name_eng;
   $farefamily->luggage_adults = $request->luggage_adults;
   $farefamily->luggage_children = $request->luggage_children;
   $farefamily->luggage_infants = $request->luggage_infants;
   $farefamily->max_stay = $request->max_stay;
   $farefamily->note_fare = $request->note_fare;
   $farefamily->created_at = Carbon::now(); 
   $farefamily->save();



  return response()->json(['farefamily' => $farefamily], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}


  public function postFareFamilyEdit(FareFamilyEditRequest $request) {

   $id = intval($request->get('id'));
   $farefamily = FareFamily::findOrFail($id);
   $farefamily->code = $request->code;
   $farefamily->name_ru = $request->name_ru;
   $farefamily->name_eng = $request->name_eng;
   $farefamily->luggage_adults = $request->luggage_adults;
   $farefamily->luggage_children = $request->luggage_children;
   $farefamily->max_stay = $request->max_stay;
   $farefamily->note_fare = $request->note_fare;
   $farefamily->updated_at = Carbon::now(); 
   $farefamily->save();


  return response()->json(['farefamily' => $farefamily], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}






   public function searchFareFamily(SearchFareFamilyRequest $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['get_farefamily'] = 1;

        $query = $request->get('query');
        $search_farefamily = FareFamily::where('name_ru', 'LIKE', "%$query%")->all();

        $total = FareFamily::where('name_ru', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
       return response()->json(['search_farefamily' => $search_farefamily, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     
     
       }
       

       else {

           return response()->json(['profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     

       }  



    }


  public function getEditProvider($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['providers'] = 1;
         $provider = Provider::findOrFail($id);



       return response()->json(['provider' => $provider, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }




  public function postProviderAdd(ProviderAddRequest $request) {
 

   $provider = new Provider;
   $provider->name_ru = $request->name_ru;
   $provider->name_eng = $request->name_eng;
   $provider->name_full_eng = $request->name_full_eng;
   $provider->name_full_ru = $request->name_full_ru;
   $provider->date_begin_at = $request->date_begin_at;
   $provider->date_end_at = $request->date_end_at;
   $provider->created_at = Carbon::now(); 
   $provider->save();

  return response()->json(['provider' => $provider], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}



  public function postProviderEdit(ProviderEditRequest $request) {
 

   $id = intval($request->get('id'));
   $provider = Provider::findOrFail($id);
   $provider->name_ru = $request->name_ru;
   $provider->name_eng = $request->name_eng;
   $provider->name_full_eng = $request->name_full_eng;
   $provider->name_full_ru = $request->name_full_ru;
   $provider->date_begin_at = $request->date_begin_at;
   $provider->date_end_at = $request->date_end_at;
   $provider->updated_at = Carbon::now(); 
   $provider->save();

  return response()->json(['provider' => $provider], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}




  public function getEditCurrency($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['currency'] = 1;
         $currency = Currency::findOrFail($id);


       return response()->json(['currency' => $currency, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }



  public function addProvider() {


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['providers'] = 1;
         $providers = Provider::all();

       return response()->json(['providers' => $providers, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }

  public function getProvider() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['providers'] = 1;
         $providers = Provider::all();


       return response()->json(['providers' => $providers, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


   public function searchProvider(SearchProviderRequest  $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $query = $request->get('query');
        $search_provider = Provider::where('name_ru', 'LIKE', "%$query%")->all();

        $total = Provider::where('name_ru', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
        return response()->json(['search_provider' => $search_provider, 'profile' => $profile, 'total' => $total,'query' => $query, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     
     
       }
       

       else {


          return response()->json(['profile' => $profile, 'total' => $total,'query' => $query, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     

       }  



    }



  public function getEditAirline($id){


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $airline = Airline::findOrFail($id);
         $cities = City::all();
         $countries = Country::all();         
 
       return response()->json(['airline' => $airline,'cities' => 
        $cities, 'profile' => $profile, 'cities'=>$cities,' 
        countries' => $countries,  'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function addCity(){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $cities = City::all();

       return response()->json([ 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user,  'cities'=>$cities, 
          'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function getCity(){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $cities = City::all();
  
       return response()->json([ 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user,  'cities'=>$cities, 
          'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }






  public function addCountry(){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $countries = Country::all();

       return response()->json([ 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 
        'countries' => $countries,  'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }





  public function getCountry(){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $countries = Country::all();

       return response()->json([ 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 
        'countries' => $countries,  'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function postCountryAdd(AddCountryRequest $request) {
 

   $country = new Country;
   $country->name_ru = $request->name_ru;
   $country->name_eng = $request->name_eng;
   $country->code_iso = $request->code_iso;
   $country->metropolis = $request->name_full_ru;
   $country->created_at = Carbon::now(); 
   $country->save();

  return response()->json(['country' => $country], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}






  public function postCountryEdit(EditCountryRequest $request) {
 
   $country = Country::findOrFail($request->id);
   $country->name_ru = $request->name_ru;
   $country->name_eng = $request->name_eng;
   $country->code_iso = $request->code_iso;
   $country->metropolis = $request->name_full_ru;
   $country->updated_at = Carbon::now(); 
   $country->save();

  return response()->json(['country' => $country], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}



public function postCityAdd(AddCityRequest $request) {
 
   $city = new City;
   $city->code_crt = $request->code_crt;
   $city->code_iata = $request->code_iata;
   $city->name_ru = $request->name_ru;
   $city->name_eng = $request->name_eng;
   $city->country_id = $request->country_id;
   $city->created_at = Carbon::now(); 
   $city->save();


  return response()->json(['city' => $city], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}






  public function postCityEdit(EditCityRequest $request) {

   $city = City::findOrFail($request->id);
   $city->code_crt = $request->code_crt;
   $city->code_iata = $request->code_iata;
   $city->name_ru = $request->name_ru;
   $city->name_eng = $request->name_eng;
   $city->country_id = $request->country_id;
   $city->updated_at = Carbon::now(); 
   $city->save();

  return response()->json(['city' => $city], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}





  public function addAirline(){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $airlines = Airline::all();
         $cities = City::all();
         $countries = Country::all();

       return response()->json(['airlines' => $airlines, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user,  'cities'=>$cities, 
        'countries' => $countries,  'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function getAirline(){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airlines'] = 1;
         $airlines = Airline::all();
         $cities = City::all();
         $countries = Country::all();

       return response()->json(['airlines' => $airlines, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user,'cities'=>$cities, 
        'countries' => $countries,  'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function getEditProviderAccount($id){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['provider_account'] = 1;
         $provider_account =ProviderAccount::findOrFail($id);
  
       return response()->json(['provider_account' => $provider_account, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  

  public function postProviderAccountAdd(ProviderAccountAddRequest $request) {

    $user = Auth::user();
   $user_id =  Auth::user()->id;
   $provider_account = new ProviderAccount;
   $provider_account->providers_id = $request->providers_id;
   $provider_account->ordering_p = $request->ordering_p;
   $provider_account->adding = $request->adding;
   $provider_account->ordering_a = $request->ordering_a;
   $provider_account->created_id = $user_id;
   $provider_account->updated_id = $user_id;
   $provider_account->login_a = $request->login_a;
   $provider_account->login_b = $request->login_b;
   $provider_account->created_at = Carbon::now(); 
   $provider_account->save();

  return response()->json(['provider_account' => $provider_account], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}


  public function postProviderAccountEdit(ProviderAccountEditRequest $request) {

   $id = intval($request->get('id'));
   $user = Auth::user();
   $user_id =  Auth::user()->id;
   $provider_account = ProviderAccount::findOrFail($id); 
   $provider_account->providers_id = $request->providers_id;
   $provider_account->ordering_p = $request->ordering_p;
   $provider_account->adding = $request->adding;
   $provider_account->ordering_a = $request->ordering_a;
   $provider_account->updated_id = $user_id;
   $provider_account->login_a = $request->login_a;
   $provider_account->login_b = $request->login_b;
   $provider_account->updated_at = Carbon::now(); 
   $provider_account->save(); 
  
  return response()->json(['provider_account' => $provider_account], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

}

  public function addProviderAccount(){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['provider_account'] = 1;
         $provider_accounts = ProviderAccount::all();


       return response()->json(['provider_accounts' => $provider_accounts, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }




  public function getProviderAccount(){

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['provider_account'] = 1;
         $provider_accounts = ProviderAccount::with('provider')->get();


       return response()->json(['provider_accounts' => $provider_accounts, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }



   public function searchProviderAccount(SearchProviderAccountRequest $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
       

        $query = $request->get('query');

        $search_passenger =ProviderAccount::where('login_a', 'LIKE', "%$query%")->orWhere('login_b', 'LIKE', "%$query%")->get();

        $total = ProviderAccount::where('login_a', 'LIKE', "%$query%")->orWhere('login_b', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
  
         return response()->json(['search_passenger' => $search_passenger, 'profile' => $profile, 'total' => $total,'query' => $query, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     
       }

       else {

         return response()->json(['profile' => $profile, 'total' => $total,'query' => $query, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  

       }  



    }


  public function getEditFareFamily($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['farefamilies'] = 1;
         $farefamily = FareFamily::findOrFail($id);


       return response()->json(['farefamily' => $farefamily, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function addFareFamily() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['farefamilies'] = 1;
         $farefamilies = FareFamily::all();


       return response()->json(['farefamilies' => $farefamilies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }

  public function getFareFamily() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['farefamilies'] = 1;
         $farefamilies = FareFamily::all();


       return response()->json(['farefamilies' => $farefamilies, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


   public function searchPassenger(Request $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['passengers'] = 1;
        $query = $request->get('query');
        $limit = (isset($request->limit))?$request->limit:10;
        $search_passenger = Passenger::where('surname', 'ilike', "%$query%")->orWhere('name', 'ilike', "%$query%")->paginate($limit);

        $total = Passenger::where('surname', 'ilike', "%$query%")->orWhere('name', 'ilike', "%$query%")->count();

       if ($total > 0) {
        
        return response()->json(['search_passenger' => $search_passenger, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');


       }
       

       else {


     return response()->json(['search_passenger' => $search_passenger, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

       }  



    }



  public function addPassenger() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['passengers'] = 1;
         $passengers = Passenger::all();

       return response()->json(['passengers' => $passengers, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }



  public function getPassenger() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['passengers'] = 1;
         $passengers = Passenger::all();

       return response()->json(['passengers' => $passengers, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }




  public function getEditPassenger($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['passengers'] = 1;
         $passenger = Passenger::findOrFail($id);
         $countries = Country::all();


       return response()->json(['passenger' => $passenger, 'profile' => $profile, 'countries'=>$countries, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }




  public function postAddPassenger(PassengerAddRequest $request) {

         $passenger = new Passenger;
         $passenger->name = $request->name;
         $passenger->surname = $request->surname;
         $passenger->country_id = $request->country_id;
         $passenger->sex_u = $request->sex_u;
         $passenger->passport_number = $request->passport_number;
         $passenger->type_documents = $request->type_documents;
         $passenger->date_birth_at = $request->date_birth_at;
         $passenger->expired = $request->expired;
         $passenger->created_at = Carbon::now(); 
         $passenger->save();



       return response()->json(['passenger' => $passenger ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }





  public function postEditPassenger(PassengerEditRequest $request) {


         $id = intval($request->get('id'));
         $passenger = Passenger::findOrFail($id);
         $passenger->name = $request->name;
         $passenger->surname = $request->surname;
         $passenger->country_id = $request->country_id;
         $passenger->sex_u = $request->sex_u;
         $passenger->passport_number = $request->passport_number;
         $passenger->type_documents = $request->type_documents;
         $passenger->date_birth_at = $request->date_birth_at;
         $passenger->expired = $request->expired;
         $passenger->updated_at = Carbon::now(); 
         $passenger->save();

       return response()->json(['passenger' => $passenger], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }





  public function getEditBCtype($id) {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['bctypes'] = 1;
         $bctype = BCType::findOrFail($id);

       return response()->json(['bctype' => $bctype, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


 


public function postAddBCtype(BCTypeAddRequest $request) {

  $bctype = new BCType;
  $bctype->name_eng = $request->name_eng;
  $bctype->name_ru = $request->name_ru;
  $bctype->aircraft_class_code = $request->aircraft_class_code;
  $bctype->ccp = $request->ccp;
  $bctype->created_at = Carbon::now(); 
  $bctype->save(); 

return response()->json(['bctype' => $bctype], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }




public function postEditBCtype(BCTypeEditRequest $request) {


         $bctype = (isset($request->id))?BCType::findOrFail($request->id):new BCType;
         $bctype->name_eng = $request->name_eng;
         $bctype->name_ru = $request->name_ru;
         $bctype->aircraft_class_code = $request->aircraft_class_code;
         $bctype->ccp = $request->ccp;
         $bctype->updated_at = Carbon::now(); 
         $bctype->save();


       return response()->json(['bctype' => $bctype], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }




     public function postEditAiroport(AiroportAddRequest $request) {
     
         $id = intval($request->get('id'));
         $aeroport = Aeroport::findOrFail($id);
         $aeroport->code_crt = $request->code_crt;
         $aeroport->name_eng = $request->name_eng;
         $aeroport->name_ru = $request->name_ru;
         $aeroport->city_id = $request->city_id;
         $aeroport->updated_at = Carbon::now(); 
         $aeroport->save();

       return response()->json(['airport' => $aeroport ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


    public function postAddAiroport(AiroportAddRequest $request) {

         $aeroport = new Aeroport;
         $aeroport->code_crt = $request->code_crt;
         $aeroport->name_eng = $request->name_eng;
         $aeroport->name_ru = $request->name_ru;
         $aeroport->city_id = $request->city_id;
         $aeroport->created_at=Carbon::now(); 
         $aeroport->save();

       return response()->json(['aeroport' => $aeroport], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function addBCtype() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['bctypes'] = 1;
         $bctypes = BCType::all();

       return response()->json(['bctypes' => $bctypes, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }



  public function getBCtype() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['bctypes'] = 1;
         $bctypes = BCType::all();

       return response()->json(['bctypes' => $bctypes, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }



  public function searchBCtype(SearchBCtypeRequest  $request) {

       $user = Auth::user();
       $user_id =  Auth::user()->id;
       $profile = Profile::where('user_id','=',$user_id)->first();
       $menuActiveItem['bctypes'] = 1; 
       $query = $request->get('query');
        $search_bctype = BCType::where('name_ru', 'LIKE', "%$query%")->get();

        $total = Aeroport::where('name_ru', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
        return response()->json(['search_bctype' => $search_bctype, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     
       }
       

       else {


      return response()->json(['profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     

       }  



    }

  public function getEditAiroport($id) {


         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airoports'] = 1;
         $airoport = Aeroport::findOrFail($id);


       return response()->json(['airoport' => $airoport, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }




  public function addAiroport() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airoports'] = 1;
         $airoports = Aeroport::all();
         $cities = City::all();
         $countries = Country::all();

       return response()->json(['airoports' => $airoports, 'cities' => $cities,'countries' => $countries,'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }


  public function getAiroport() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['airoports'] = 1;
         $airoports = Aeroport::all();
         $cities = City::all();
         $countries = Country::all();

       return response()->json(['airoports' => $airoports, 'cities' => $cities,'countries' => $countries,'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }



   public function searchAeroport(SearchAeroportRequest  $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['airoports'] = 1;

        $query = $request->get('query');
        $search_aeroport = Aeroport::where('name_ru', 'LIKE', "%$query%")->get();

        $total = Aeroport::where('name_ru', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
         return response()->json(['search_aeroport' => $search_aeroport, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     
     
       }
       

       else {


          return response()->json(['profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     

       }  



    }


  public function addTypeFee() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['typefees'] = 1;
         $typefees = TypeFee::all();


       return response()->json(['typefees' => $typefees, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

  }



  public function getTypeFee() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $menuActiveItem['typefees'] = 1;
         $typefees = TypeFee::all();

       return response()->json(['typefees' => $typefees, 'profile' => $profile, 'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');;

  }





  public function searchTypeFee(SearchTypeFeeRequest  $request) {

        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
       
        $menuActiveItem['typefees'] = 1;
        $query = $request->get('query');
        $search_typefee = TypeFee::where('name_ru', 'LIKE', "%$query%")->get();

        $total = TypeFee::where('name_ru', 'LIKE', "%$query%")->count();

       if ($total > 0) {
        
         return response()->json(['search_typefee' => $search_typefee, 'profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

       }

       else {


          return response()->json(['profile' => $profile, 'total' => $total,'query' => $query,'menuActiveItem' => $menuActiveItem, 'user' => $user, 'profile' => $profile ], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
     

       }  



    }


  public function postTypeFeeAdd(TypeFeeAddRequest $request) {
 

   $typefee = new TypeFee;
   $typefee->name_ru = $request->name_ru;
   $typefee->name_eng = $request->name_eng;
   $typefee->date_of_start = $request->date_of_start;
   $typefee->date_of_stop = $request->date_of_stop;
   $typefee->created_at = Carbon::now(); 
   $typefee->save();

  return response()->json(['typefee' => $typefee], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

}



  public function postTypeFeeEdit(TypeFeeEditRequest $request) {
 
 
   $id = intval($request->get('id'));
   $typefee = TypeFee::findOrFail($id);
   $typefee->name_ru = $request->name_ru;
   $typefee->name_eng = $request->name_eng;
   $typefee->date_of_start = $request->date_of_start;
   $typefee->date_of_stop = $request->date_of_stop;
   $typefee->updated_at = Carbon::now(); 
   $typefee->save();



  return response()->json(['typefee' => $typefee], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

}



}
