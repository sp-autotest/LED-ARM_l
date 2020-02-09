<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\City;
use App\Country;
use App\Currency;
use App\Order;
use App\Service;
use App\Aeroport;
use App\AdminCompany;
use App\User;
use App\Profile;
use Auth;
use Carbon\Carbon;
use PDF;
use Response;
class AxiosController extends Controller
{
	public $successStatus = 200;
	public $errorStatus = 400;

	public function getCompanies(Request $request){
		return ['data' => AdminCompany::where('company_name', 'ilike', '%'.urldecode($request->q).'%')->orWhere('legal_company_name', 'ilike', '%'.urldecode($request->q).'%')->get()->toArray()];
	}

	/*
	RETURN ARRAY  =  [
		airport_id = [
			airport = array,
			country = array, 
			city = array
		]
	]
	*/
	public function getACCs(Request $request){
		$return = [];
		$return['cities'] = City::all();
		$return['countries'] = Country::all();
		$return['airports'] = Aeroport::all();
		return response()->json(['return' => $return], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
	}
	public function countryAdd(Request $request)
	{
		$country = new Country;

$country->name_ru =	$request->name_ru;
$country->name_eng = $request->name_eng;
$country->code_iso	= $request->code_iso;
$country->metropolis =	$request->metropolis;
	$country->save();
		return response()->json(['return' => $country], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}
	public function cityAdd(Request $request)
	{
		$city = new City;
		$city->code_crt	= $request->code_crt	;
		$city->code_iata = $request->code_iata	;
		$city->name_ru	= $request->name_ru	;
		$city->name_eng	= $request->name_eng	;
		$city->country_id = $request->country_id;
		$city->save();
		return response()->json(['return' => $city], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}
	public function airportAdd(Request $request)
	{
		$airport = new Aeroport;
		$airport->code_crt	= $request->code_crt	;
		$airport->code_iata = $request->code_iata	;
		$airport->name_ru	= $request->name_ru	;
		$airport->name_eng	= $request->name_eng	;
		$airport->city_id = $request->city_id;
		$airport->save();
		return response()->json(['return' => $airport], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}

	public function countryEdit(Request $request)
	{
		$country = Country::find($request->id);

$country->name_ru =	$request->name_ru;
$country->name_eng = $request->name_eng;
$country->code_iso	= $request->code_iso;
$country->metropolis =	$request->metropolis;
	$country->save();

		return response()->json(['return' => $country], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}

	public function findData(Request $request)
	{
		$this->middleware(['role_or_permission:search.index']);
		$query = $request->q;

			$order = (isset($request->orderby))?$request->orderby:'updated_at';
			$limit = (isset($request->limit))?$request->limit:10;
			$na = (isset($request->na))?$request->na:'desc';
	switch ($request->type) {
		case 'order':

			if ($request->field == 'number') {
				
					return Order::where('order_n', 'ilike', '%'.$request->q.'%')
					->orderBy($order, $na)
					->paginate($limit);
			}elseif ($request->field == 'ticket') {
				$ids = Service::whereHas('passenger.ticket', 	function($q) use ($request){
						$q->where('ticket_number', 'ilike', '%'.$request->q.'%');
					}
				)->select('order_id')->get();
				return Order::whereIn('id', $ids)->paginate($limit);
			}elseif ($request->field == 'flight') {
				$ids = Service::whereHas('flight.flightplaces.schedule', 	function($q) use ($request){
						$q->where('flights', 'ilike', '%'.$request->q.'%');
					}
				)->select('order_id')->get();
				return Order::whereIn('id', $ids)->paginate($limit);
			}elseif($request->field == 'pnr'){
				$ids = Service::where('pnr', 'ilike', '%'.$request->q.'%')->select('order_id')->get();
				return Order::whereIn('id', $ids)->paginate($limit);
			}elseif($request->field == 'company'){
				return Order::whereHas('company', function($q) use ($request){
					$q->where('company_name', 'ilike', '%'.$request->q.'%');
				})->paginate($limit);
			}elseif($request->field == 'user'){
				return Order::whereHas('user.profile', function($q) use ($request){
					$q->where('first_name', 'ilike', '%'.$request->q.'%')->orWhere('second_name', 'ilike', '%'.$request->q.'%');
				})->paginate($limit);
			}else{
				$ids =	Service::whereHas('flight.flightplaces.schedule', 	function($q) use ($request){
						$q->where('flights', 'ilike', '%'.$request->q.'%');
					}
				)->orWhereHas('passenger.ticket', 	function($q) use ($request){
						$q->where('ticket_number', 'ilike', '%'.$request->q.'%');
					}
				)->orWhere('pnr', 'ilike', '%'.$request->q.'%')->select('order_id')->get();

				return Order::where('order_n', 'ilike', '%'.$request->q.'%')
							->orWhereIn('id', $ids)
							->orWhereHas('user.profile', function($q) use ($request){
								$q->where('first_name', 'ilike', '%'.$request->q.'%')->orWhere('second_name', 'ilike', '%'.$request->q.'%');
							})
							->orWhereHas('company', function($q) use ($request){
								$q->where('company_name', 'ilike', '%'.$request->q.'%');
							})->paginate($limit);
			}
								
						
				
				
				/*$field = $request->field;
				
				return Order::where($field, 'ilike', '%'.$request->q.'%')
						->orderBy($order, $na)
						->paginate($limit);*/
				break;
			case 'users':
				# code...
				break;
			default:
				# code...
				break;
		}
		

	}
	public function cityEdit(Request $request)
	{
		$city = City::find($request->id);
		$city->code_crt	= $request->code_crt	;
		$city->code_iata = $request->code_iata	;
		$city->name_ru	= $request->name_ru	;
		$city->name_eng	= $request->name_eng	;
		$city->country_id = $request->country_id;
		$city->save();
		return response()->json(['return' => $city], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}

	public function airportEdit(Request $request)
	{
		$airport = Aeroport::find($request->id);
		$airport->code_crt	= $request->code_crt	;
		$airport->code_iata = $request->code_iata	;
		$airport->name_ru	= $request->name_ru	;
		$airport->name_eng	= $request->name_eng	;
		$airport->city_id = $request->city_id;
		$airport->save();
		return response()->json(['return' => $airport], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}
	public function countryDelete(Request $request)
	{
		$country = Country::delete($request->country_id);
		return response()->json(['return' => 'TRUE'], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}
	public function cityDelete(Request $request)
	{
		$city = City::delete($request->city_id);
		return response()->json(['return' => 'TRUE'], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}
	public function airportDelete(Request $request)
	{
		$airport = Aeroport::delete($request->airport_id);
		return response()->json(['return' => 'TRUE'], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

	}
	public function getCities(Request $request){
		return City::where('name_ru', 'ilike', '%'.urldecode($request->q).'%')->orWhere('name_eng', 'ilike', '%'.urldecode($request->q).'%')->get()->toArray();
	}
	public function getCounties(Request $request){
		if(!isset($request->q)){
			$countries = Country::all();
		}else{

		$countries = Country::where('name_ru', 'ilike', '%'.urldecode($request->q).'%')->orWhere('name_eng', 'ilike', '%'.urldecode($request->q).'%')->get()->toArray();
		}

	return response()->json(['countries' => $countries], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
	}
	public function getAirportsByCity(Request $request){
		$countries = Country::where('name_ru', 'ilike', '%'.urldecode($request->q).'%')->orWhere('name_eng', 'ilike', '%'.urldecode($request->q).'%')->with('citiesWithAirports')->get()->toArray();

		foreach ($countries as $key => $value) {
			foreach ($value['cities_with_airports'] as $cwkey => $cwvalue) {
				foreach ($cwvalue['airports'] as $aikey => $aivalue) {
					$return[$aivalue['id']] = ['airport_name_ru' => $aivalue['name_ru'], 'airport_name_eng' => $aivalue['name_eng'], 'airport' => $aivalue, 'city' => $cwvalue, 'country' => $value];
				}
			}
		}
		
		$cities = City::where('name_ru', 'ilike', '%'.urldecode($request->q).'%')->orWhere('name_eng', 'ilike', '%'.urldecode($request->q).'%')->with(['airports', 'country'])->get()->toArray();
		
		foreach ($cities as $ckey => $cvalue) {
			foreach ($cvalue['airports'] as $aikey => $aivalue) {
				$return[$aivalue['id']] = ['airport_name_ru' => $aivalue['name_ru'], 'airport_name_eng' => $aivalue['name_eng'], 'airport' => $aivalue, 'city' => $cvalue, 'country' => $cvalue['country']];
			}
		}
		
		$airport = Aeroport::where('name_ru', 'ilike', '%'.urldecode($request->q).'%')->orWhere('name_eng', 'ilike', '%'.urldecode($request->q).'%')->with(['city', 'city.country'])->get()->toArray();
		 
		foreach ($airport as $akey => $avalue) {
			$acountry = $avalue['city']['country'];
			$acity = $avalue['city'];
			$airport = $avalue;
			$return[$avalue['id']] = ['airport_name_ru' => $avalue['name_ru'], 'airport_name_eng' => $avalue['name_eng'], 'airport' => $avalue, 'city' => $avalue['city'], 'country' => $acountry];
		}
		return response()->json(['data' => $return], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
		//return ['data' =>$return];
		//dd($countries, $cities, $airport);
	}

	public function allCurrencies(){
		return Currency::all();
	}

	public function generatePdfAccount(Request $request){
		$usercompany = (isset($request->company))?AdminCompany::where('id', '=', $request->company)->first() : Auth::user()->admincompany()->with('currency')->first();
        if($usercompany->invoice_payment == false){
            return response()->json(['status' => 'error', 'message' => 'you have not access to generate bill'], $this->errorStatus)->header('Access-Control-Allow-Origin', '*');
        }
        if($usercompany->parent == null){
            return response()->json(['status' => 'error', 'message' => 'you have not parrent company'], $this->errorStatus)->header('Access-Control-Allow-Origin', '*');

        }
		$parentcompany = $usercompany->parent()->first();
		$parentcompany->countnumber += $request->count;
		$parentcompany->save();
setlocale(LC_TIME, 'ru_RU.UTF-8');
		$date = Carbon::now()->formatLocalized("%d %B %Y");
		$summ = $request->summ;

		switch ($usercompany->currency_id) {
			case '1':
				$lang = 'de';
				$curr = false;
				break;
			case '2':
				$lang = 'ru';
				$curr = false;
				break;
			case '3':
				$lang = 'ru';
				$curr = false;
				break;
			case '4':
				$lang = 'ru';
				$curr = false;
				break;
			case '5':
				$lang = 'en';
				$curr = false;
				break;
			
			default:
				$lang = 'ru';
				$curr = false;
				break;
		}

		$data = ['request' => ['summ' => $summ, 'curr' => $curr, 'lang' => $lang, 'count' => $request->count], 'cp' => $parentcompany, 'uc' => $usercompany, 'date' => $date];
		 $pdf = PDF::loadView('reports.account', $data);

		//$pdf->save(storage_path().'account.pdf');
 		$headers = array(
             // 'Content-Type: application/pdf',
              'Access-Control-Allow-Origin', '*'
            );

		$filename = time().Auth::user()->id.'.pdf';
		$path = storage_path('app/public/accounts/').$filename;
		$pdf->save($path);
   		return '/storage/accounts/'.$filename;
	}
}
