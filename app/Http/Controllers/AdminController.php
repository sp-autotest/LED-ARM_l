<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Profile;
use Image;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\AdminCompany;

use Illuminate\Http\UploadedFile;
use App\Http\Requests\UpdateProfileRequest;


class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


   public function index() {
        $user = Auth::user();
        $clientIP = \Request::getClientIp(true);
        $user_id =  Auth::user()->id;
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $clientIP
        ]);
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['admin'] = 1;

        return view('admin.index')->with('user',$user)->with('profile',$profile)->with('menuActiveItem', $menuActiveItem);
    }



    public function profile() {
        $clientIP = \Request::getClientIp(true);
        $user = Auth::user();
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $clientIP
        ]);
        $profiles = Profile::where('user_id','=',$user->id)->first();
        $menuActiveItem['admin'] = 1;

        return view('admin.profile')->with('user',$user)->with('profile',$profiles)->with('menuActiveItem', $menuActiveItem);
    }




    public function test() {
        $clientIP = \Request::getClientIp(true);
        $user = Auth::user();
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $clientIP
        ]);
        $profile = Profile::where('user_id','=',$user->id)->first();
        $menuActiveItem['admin_test'] = 1;

        return view('admin.test')->with('user',$user)->with('profile',$profile)->with('menuActiveItem', $menuActiveItem);
    }


    public function companies() {
        $menuActiveItem['admin_companies'] = 1;
        return view('admin.companies', ['menuActiveItem' => $menuActiveItem]);
    }

    public function updateProfile(UpdateProfileRequest $request) {
        

        $email=$request->get('email');
        $uid=intval($request->get('uid'));
        $user = User::where('id','=', $uid)->first();
        $user->email = $email;
        $user->save();
        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
         Image::make($avatar)->resize(300, 300)->save( storage_path('app/public/avatars/' .$filename ));

        $result = Profile::where( 'user_id', '=',  $uid)->get()->count();

        if ($result == 0) {

        $profile = new Profile;
        $profile->avatar = $filename;
        $profile->user_id = $uid;
        $profile->first_name = $request->get('first_name');
        $profile->middle_name = $request->get('middle_name');
        $profile->second_name = $request->get('second_name');
        $profile->created_at = Carbon::now();
        $profile->save();

       } else {

        $profile= Profile::where('user_id','=', $uid)->first();
        $profile->avatar = $filename;
        $profile->first_name = $request->get('first_name');
        $profile->middle_name = $request->get('middle_name');
        $profile->second_name = $request->get('second_name');
        $profile->updated_at = Carbon::now();
        $profile->save();
        
       }




 $data = [

'email'=>  $request->get('email'),
'first_name'=>$request->get('first_name'),
'middle_name'=>$request->get('middle_name'),
'second_name'=>$request->get('second_name'),

];
 


\Mail::send('emails.update_profile', $data, function($message)
{
$message->from(env('MAIL_FROM'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'));
$message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($email);
$message->subject('Профиль пользователя обновлен');
   });

        return redirect('admin');
    }


    public function getPasswords() {
        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        return view('admin.passwords')->with('user',$user)->with('profile',$profile);
    }

     public function updatePassword(UpdatePasswordRequest $request) {
        $newpassword = bcrypt($request->get('password'));
        $uid=intval($request->get('uid'));
        $user = User::where('id','=', $uid)->first();
        $user->password = $newpassword;
        $user->save();


         $user_email = User::getEmail($uid);
         $user_name = User::getName($uid);
          

         $data = [
            'user_name'=> $user_name,
            'email'=> $user_email,
            'password'=> $request->get('password'),
        ];


        \Mail::send('emails.adminpasswords', $data, function($message)
        {
            $message->from(env('MAIL_FROM'));
            $message->to(env('MAIL_FROM'), env('MAIL_NAME'));
            $message->to(env('MAIL_FROM'), env('MAIL_NAME'))->cc($user_emai);
            $message->subject('Пароль был изменен');
        });


        return redirect('admin');
    }


    public function messages() {
        $user_id =  Auth::user()->id;
        $profile = Profile::where('user_id','=',$user_id)->first();
        $menuActiveItem['admin_messages'] = 1;
        return view('admin.messages', ['menuActiveItem' => $menuActiveItem])->with('profile',$profile);
    }
}