<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;

class AdminControllerNew extends Controller
{
    public function admin_login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid Admin Credentials'
            ], 401);
        }
        $user = $request->user();
        //return $user;
        if ($user->blocked == 1) {
            return response()->json([
                'message' => 'Your account is blocked',
                'status'=>404
            ], 403);
        } 
        if($user->usertype < 8 ) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(20);
        $token->save();
        $roles = User::where(['id' => $user['id']])->with('roles')->first();
        /*foreach($roles['roles'] as $role => $value) {
            foreach($value['permissions'] as $permission => $value1) {
                $permissions[] = $value1['permission_name'];
            }
        } */
    
        return response()->json([
            'username' => $user->name,
            'id' => $user->id,
            'usertype' => $user->usertype,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'misc' => $user,
            'roles' => $roles->roles
        ]);
        

    }

    public function user_block_status(Request $request)
    {
        $user_id = Auth::user()->id;
        $data = user::where(['id'=>$user_id])->first();
       
        return response()->json([
            'data' =>$data,
        ], 201);
    }
    public function get_user_permissions($user_id) {
        $roles = User::where(['id' => $user_id])->with('roles')->first();
        $permissions = array();
        foreach($roles['roles'] as $role => $value) {
            foreach($value['permissions'] as $permission => $value1) {
                $permissions[] = $value1['permission_name'];
            }
        }
        return response()->json([
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    public function get_user_area_group($user_id) {
        $user = User::where(['id' => $user_id])->with('area_group_data')->first();
        $permissions = array();
        foreach($user->area_group_data as $group => $value) {
            foreach($value['area_group_permission']->pivot_data as $permission => $value1) {
                $permissions[] = $value1['sub_locality_id'];
            }
        } 
        $permission_unique=array_unique($permissions);
        return response()->json([
            'user' => $user,
            'permissions' => $permission_unique
        ]);
    }
}
