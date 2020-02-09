<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Profile;
use App\Message;
use App\Conversation;

use Auth;
use App\Events\Message as EMessage;

use Image;
use Spatie\Permission\Models\Role;
use View;
use Carbon\Carbon;

use App\AdminCompany as Company;


class UserController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

	public function listbyparent(Request $request){
		$staff = Company::where('id', '=', $request->id)->first()->staff()->get();
		 return response()
                   ->json(['users' => $staff], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
	}

	public function index(Request $request){
        $company = (isset($request->company))?$request->company:Auth::user()->company_id;
       $users = User::where('company_id', '=', $company)->with(['admincompany','roles', 'roles.permissions', "profile", "admincompany.account", "admincompany.currency"])->get();
        return response()
                   ->json(['users' => $users], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
	}

	public function show($id){
		 return response()
                   ->json(['user' => User::where('id', '=', $id)->first()], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
	}


	public function createSystemMessage($text){
        $message = new Message;
        $message->conversation_id = Conversation::where('name' , 'system_messages_'. Auth::user()->id)->first()->id;
        $message->text = $text;
        $message->user_id = null;
        $message->is_read = false;
        $message->save();
        event(new EMessage($message, 'System Message'));
       return $message;

    }
	public function updateUser(Request $request){
		$user = User::where('id', '=', $request->id)->first();
		if(!$user){return response()
            ->json(['ERROR' => 'UNDEFINED USER'], $this->errorStatus)
            ->header('Access-Control-Allow-Origin', '*');}
		if(isset($request->company_id)){$user->company_id = $request->company_id;}
		if(isset($request->active)){$user->active = $request->active;}
		if(isset($request->email)){$user->email = $request->email;}
		if(isset($request->password)){$user->password = bcrypt($request->password);}
		if(isset($request->is_admin)){$user->is_admin = $request->is_admin;}
		if(isset($request->company_id)){$user->company_id = $request->company_id;}
		if(isset($request->company_id)){$user->company_id = $request->company_id;}
		if(isset($request->company_id)){$user->company_id = $request->company_id;}
		if(isset($request->company_id)){$user->company_id = $request->company_id;}
		$user->save();
		$profile = Profile::where('user_id', '=', $request->id)->first();
		if(isset($request->first_name)){$profile->first_name = $request->first_name;}
		if(isset($request->second_name)){$profile->second_name = $request->second_name;}
		if(isset($request->middle_name)){$profile->middle_name = $request->middle_name;}
		if(isset($request->phone)){$profile->phone = $request->phone;}
		if(isset($request->additional_phone)){$profile->additional_phone = $request->additional_phone;}
		if(isset($request->additional_email)){$profile->additional_email = $request->additional_email;}
		if(isset($request->sex)){$profile->sex = $request->sex;}
		if(isset($request->position)){$profile->position = $request->position;}
		$profile->save();
		if(isset($request->role)){ $user->syncRoles($request->role); }

		
		
		 return response()
                   ->json(['user' => $user, 'profile' => $profile], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
	}
	
	public function storeNewUser(Request $request){
		$user = new User;
		$user->company_id = $request->company_id;
		$user->active = $request->active;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->is_admin = false;
		$user->save();
		$profile = new Profile;
		$profile->first_name = $request->first_name;
		$profile->second_name = $request->second_name;
		$profile->middle_name = $request->middle_name;
		$profile->phone = $request->phone;
		$profile->additional_phone = $request->additional_phone;
		$profile->additional_email = $request->additional_email;
		$profile->sex = $request->sex;
		$profile->position = $request->position;
		$profile->save();
		$user->profile()->save($profile);
		$role = Role::findByName($request->role, 'api');
		$user->syncRoles($role);
		
		

		
		$systemconversation = Conversation::create(['name' => 'system_messages_'.$user->id]);
		$user->conversations()->attach($systemconversation->id);

		$text = "Логин: ".$user->email."  Пароль:". $request->password;
		$this->createSystemMessage($text);
		

		 return response()
                   ->json(['user' => $user, 'profile' => $profile, 'login' => $user->email, 'password' => $request->password], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
	}
	public function searchUser(Request $request)
    {
        $users = User::whereHas('profile', function($q) use ($request) {
            $search = explode(" ", $request->q);
            $q->where("first_name","ilike", '%'.$request->q.'%')
                ->orWhere("second_name","ilike", '%'.$request->q.'%')
                ->orWhere("middle_name","ilike", '%'.$request->q.'%');
            foreach ($search as $s){
                $q->orWhere("first_name","ilike", '%'.$s.'%');
                $q->orWhere("second_name","ilike", '%'.$s.'%');
                $q->orWhere("middle_name","ilike", '%'.$s.'%');
            }

        })->orWhere('email', 'ilike', '%'.$request->q.'%')->get();

        return response()
            ->json(['users' => $users], $this->successStatus)
            ->header('Access-Control-Allow-Origin', '*');
    }
}
