<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BCType;

class BCTypesController extends Controller
{
	public $successStatus = 200;

    public function allbc(){
    	return response()->json(['bctypes' => BCType::all()], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
    }
}
