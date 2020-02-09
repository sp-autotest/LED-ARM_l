<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ElectronicTicketsPicture as ETP;
use Auth;
class AdvertisingController extends Controller
{

    public $successStatus = 200;
    public $errorStatus = '400';

    public function index(Request $request){
    	$data = [];
        $data['pictures'] = [];
        $company = (isset($request->company))?$request->company:Auth::user()->company_id;
    	$pictures = ETP::where('companies_id', '=', $company)->get();
    	foreach($pictures as $key=>$value){
    		$value['url'] = env('BACK_DOMAIN').'/storage/advertising/electronic_tickets_pictures/'.$value->name;
            $data['pictures'][] = $value;
    	}
        return response()->json(['data' => $data], $this->successStatus);
    }

    public function delete(Request $request){
        if(ETP::where('id', '=', $request->id)->delete()){
            return response()->json(['status' => 'true'], $this->successStatus);
        }
        return response()->json(['status' => 'false'], $this->errorStatus);
    }
    public function save(Request $request){

    	
    	$file = $request->file('file');

    	$ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $name = $request->image_position.'_'.Auth::user()->company_id;

    	$path = '/storage'.substr($file->storeAs('public/advertising/electronic_tickets_pictures', $name.'.'.$ext), 6, 1024);

    	ETP::where('name', $name)->delete();
    	$return = ETP::create(['name' => $name, 'path' => $path, 'status' => true, 'created_id' => Auth::id(), 'updated_id' => Auth::id(), 'companies_id' => Auth::user()->company_id]);

        return response()->json(['data' => $return], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
    }
}
