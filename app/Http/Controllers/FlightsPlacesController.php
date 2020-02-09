<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; 
use App\Profile;
use App\Flight;
use App\Country;
use App\FeePlace;
use App\TypeFee;
use App\Airline;
use App\Aeroport;
use App\FareFamily;
use App\BCType;
use App\Currency;
use App\Schedule;
use DB;


class FlightsPlacesController extends Controller
{

    public function __construct() {

        $this->middleware('auth');
        
    }




  public function index() {

         $user = Auth::user();
         $user_id =  Auth::user()->id;
         $profile = Profile::where('user_id','=',$user_id)->first();
         $flights = Flight::sortable()->paginate(10);
         $menuActiveItem['feesplaces'] = 1;
         $typefees =  TypeFee::paginate(10);
         $cities = City::paginate(10);
         $airlines = Airline::paginate(10);
         $airports = Aeroport::paginate(10);
         $farefamilies = FareFamily::paginate(10);


        return view('feesplaces.index')->with('feesplaces',$feesplaces)->with('profile',$profile)->with('menuActiveItem', $menuActiveItem)->with('profile',$profile)->with('typefees',$typefees)->with('flights',$flights)->with('cities', $cities)->with('airlines', $airlines)->with('airports', $airports)->with('farefamilies',$farefamilies);

 }




}
