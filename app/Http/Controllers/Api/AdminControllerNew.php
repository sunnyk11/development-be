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
}
