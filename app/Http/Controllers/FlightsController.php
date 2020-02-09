<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Profile;
use View;
use Carbon\Carbon;
use App\Flight;


class FlightsController extends Controller
{

    public $successStatus = 200;
    public function __construct() {

        $this->middleware('auth');
        
    }

    public function edit($id, Request $request){
        $f = Flight::where('id', '=', $id)->first();
        if(isset($request->ow)){$f->ow = $request->ow;}
        if(isset($request->rt)){$f->rt = $request->rt;}
        if(isset($request->infant_ow)){$f->infant_ow = $request->infant_ow;}
        if(isset($request->infant_rt)){$f->infant_rt = $request->infant_rt;}
        if($request->count_places <= $f->count_places_reservation){
            $count_places = $f->count_places;
        }else{
            $count_places = $request->count_places;
        }
        $f->count_places = $count_places;
        $f->save();
        return response()->json(['flight' => $f], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
    }


    public function index(Request $request) {
        $limit = (isset($request->limit))?$request->limit:10;
        if(isset($request->q)){
            $flights = Flight::where('date_departure_at', 'ilike', '%'.$request->q.'%')->with([
                'flightplaces',
                'flightplaces.farefamily',
                'flightplaces.currency',
                'flightplaces.schedule',
                'flightplaces.schedule.childs',
                'flightplaces.schedule.arrival',
                'flightplaces.schedule.arrival.city',
                'flightplaces.schedule.departure',
                'flightplaces.schedule.departure.city',
                'flightplaces.schedule.airline',
            ])->orderBy('created_at', 'desk')->paginate($limit);
        }else{
         $flights = Flight::with([
              'flightplaces', 
              'flightplaces.farefamily',
              'flightplaces.currency',
              'flightplaces.schedule',
              'flightplaces.schedule.childs',
              'flightplaces.schedule.arrival',
              'flightplaces.schedule.arrival.city',
              'flightplaces.schedule.departure',
              'flightplaces.schedule.departure.city',
              'flightplaces.schedule.airline',
        ])->orderBy('created_at', 'desk')->paginate($limit);}
         return response()->json(['flights' => $flights], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 

    }
}