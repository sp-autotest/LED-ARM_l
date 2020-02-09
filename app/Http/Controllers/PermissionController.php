<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Auth;
use App\User;
use App\Profile;
use Image;
use View;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Spatie\Permission\Models\Permission::create(['name' => 'permission:permissions.access.edit']);
 * Permission::create(['name' => 'permission:permissions.role.create']);
 * Permission::create(['name' => 'permission:permissions.role.edit']);
 * Permission::create(['name' => 'permission:permissions.role.delete']);
 * Permission::create(['name' => 'permission:permissions.role.show']);
 **/
		
	
		
class PermissionController extends Controller
{
	public $successStatus = 200;
	public $errorStatus = 400;

	public function __construct(){
		$this->middleware(['auth' ]);
	}

	
	public function getGroupAdd(Request $request){
        $clientIP = \Request::getClientIp(true);
        $user = Auth::user();
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $clientIP
        ]);
        $profile = Profile::where('user_id','=',$user->id)->first();
        $menuActiveItem['admin'] = 1;
      
		$permissions = Permission::all();
		
		$permissionsAr = [];
		
		foreach($permissions as $key=>$value){
			//print_r($value->name);
			$value = $value->name;
			$permissionsAr[$value]  = explode (".", $value);
		}
		$data['permissions'] = $permissions;
		$data['permissionsAr'] = $permissionsAr;
		
		return view('permissions.role.create')->with('user',$user)->with('profile',$profile)->with('menuActiveItem', $menuActiveItem)->with('data', $data);
	}
	
	
	
	
	public function permissionsUpdate(Request $request)
	{
	    $perms = [];
	    foreach ($request->permissions as $k=>$v){
	        $perms[] = $v;
        }
		        Role::where('id', '=', $request->id)->first()->syncPermissions($perms);
		$role = Role::where('id', '=', $request->id)->with('permissions')->get();
		
		return response()->json(['role' => $role], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
	}
	

	public function getPermissions(Request $request){
		$roles = Role::find($request->id)->permissions()->select(['name'])->get()->toArray();
		$return = [];
		foreach ($roles as $key => $value) {
			$return[] = $value['name'];
		}
		 return response()->json(['permissions' => $return], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
	}
	public function getAllPermissions(Request $request){
		 return response()->json(['permissions' => Permission::all()], $this->successStatus)->header('Access-Control-Allow-Origin', '*'); 
	}
	public function getGroups(){
		return response()->json(['groups' => Role::with('users')->get()], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
	}
    public function postGroupAdd(Request $request){

		$name = $request->name;
		
		$role = Role::create(['name' => $name]);
		return response()->json(['role' => $role], $this->successStatus)->header('Access-Control-Allow-Origin', '*');
	}
	
	

	public function postGroupDelete(Request $request){
       // $this->middleware(['permission:permission:role-delete']);
		$role = Role::find($request->id);
        if($role->name == 'admin'){	return response()->json(['status' => 'error', 'message' => 'Group "admin" is indestructible'], $this->errorStatus)->header('Access-Control-Allow-Origin', '*');
}
			$role->delete();
        return response()->json(['status' => 'success'], $this->successStatus)->header('Access-Control-Allow-Origin', '*');

		//redirect('/admin/permissions');
	}
}