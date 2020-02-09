<?php

namespace App\Http\Controllers;

use App\AdminCompany as Company;
use Illuminate\Http\Request;
use App\History;
use Auth;

class HistoryController extends Controller
{
    public $successStatus = 200;
    public function index(Request $request){
        $companyid = (isset($request->company))?$request->company:Auth::user()->company_id;
        $users = array_map(function($item){return $item['id'];},  Company::where('id', '=', $companyid)->first()->staff()->get()->toArray());

        $history = History::whereIn('author', $users)->orderBy('created_at', 'desc')->paginate(10)->toArray();
        $data = [];
        foreach ($history['data'] as $key => $value) {

            $past = json_decode($value['past_json'], 1);
            $now = json_decode($value['now_json'], 1);
            foreach ($now as $k=>$item){
                if($k == 'id'){continue;}
                if(isset($past[$k]) && $past[$k] == $item){continue;}
                $data['data'][$value['id']]['full'][$k] = $value;
                $data['data'][$value['id']]['now'][$k] = $item;
                if(isset($past[$k])){
                    $data['data'][$value['id']]['past'][$k] = $past[$k];
                }else{
                    $data['data'][$value['id']]['past'][$k] = [];
                }
            }

        }
        $history['merged_data'] = $data;
        return response()->json(['data' => $history], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
    }

    public function bydate($date){
        return response()->json(['data' => History::where('created_at', '=', $date)->orderBy('created_at', 'desc')->paginate(10)], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
    }

}
