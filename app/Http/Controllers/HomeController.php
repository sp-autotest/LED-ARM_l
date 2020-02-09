<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Profile;
use Image;
use View;
use Carbon\Carbon;


/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $clientIP = \Request::getClientIp(true);
        $user = Auth::user();
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $clientIP
        ]);
        $profile = Profile::where('user_id','=',$user->id)->first();
        $menuActiveItem['admin'] = 1;

        return view('home')->with('user',$user)->with('profile',$profile)->with('menuActiveItem', $menuActiveItem);
    }
}
