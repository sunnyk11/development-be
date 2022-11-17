<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolesPermissionsController extends Controller
{
    public function get_permissions() {
        $permissions = DB::table('permissions')->get();
        return response()->json([
            'data' => $permissions
        ], 200);
    }

    public function create_role(Request $request) {

        $request->validate([
            'role_name' => 'required|unique:roles'
        ]);

        $role = new Role([
            'role_name' => $request->role_name,
            'description' =>$request->roleDesc
        ]);
        

        //return $request->permissionsArray;
        //return gettype($request->permissionsArray);
        $permission_id=[];
        foreach($request->permissionsArray as $permission => $value) {
            if($value == true) {
                $permission_id[] = DB::table('permissions')->where('permission_name', $permission)->first()->id;
            }
        }
        //return $permission_id;
        if(count($permission_id)){
              $result = $role->save();
              $role->permissions()->attach($permission_id);
            return response() -> json([
                'message' => 'SUCCESS',
                'description'=>'Roles SUCCESSfully Created',
                'status'=> 200,
            ]);
        }else{

            return response() -> json([
                'message' => 'FAIL',
                'error'=>'Atleast One Selected Permission',
                'status'=> 401,
            ]);
        }

    }

    public function get_roles() {
        $roles = DB::table('roles')->get();
        return response()->json([
            'roles' => $roles
        ], 200);
    }

    public function get_role_permissions(Request $request) {
        $role_permissions =  DB::table('roles_permissions')->where('role_id', $request->role_id)->get();
        $permissions = DB::table('permissions')->get();
        foreach($permissions as $p) {
            $p->status = false;
        }
        foreach($role_permissions as $val) {
            foreach($permissions as $val1) {
                if($val->permission_id == $val1->id) {
                    $val1->status = true;
                }
            }
        }
        return $permissions;
    }

    public function edit_role(Request $request) {
        //return $request;
        $request->validate([
            'role_id' => 'required'
        ]);

        $role = Role::where('id', $request->role_id)->first();
        $role->permissions()->detach();
        $permission_id=[];
        foreach($request->permissionsArray['EditPermissionsArray'] as $permission => $value) { 
            if($value == true) {
                $permission_id[] = DB::table('permissions')->where('permission_name', $permission)->first()->id;
            }
        }

        //return $permission_id;
        if(count($permission_id)){
              $result = $role->save();
              $role->permissions()->attach($permission_id);
            return response() -> json([
                'message' => 'SUCCESS',
                'description'=>'Roles SUCCESSfully Created',
                'status'=> 200,
            ]);
        }else{

            return response() -> json([
                'message' => 'FAIL',
                'error'=>'Atleast One Selected Permission',
                'status'=> 401,
            ]);
        }
    }

    public function delete_role(Request $request) {
        $request->validate([
            'role_id' => 'required'
        ]);

        $role = Role::where('id', $request->role_id)->first();
        $role->delete();
        $role->permissions()->detach();
        return response() -> json ([
            'message' => 'The role has been deleted.'
        ]); 
    }

    public function get_user_roles($user_id) {
        $roles = DB::table('roles')->get();
        $internal_user_roles =  DB::table('user_roles_pivot')->where('user_id', $user_id)->get();
        foreach($roles as $role) {
            $role->status = false;
        }
        foreach($internal_user_roles as $val) {
            foreach($roles as $val1) {
                if($val->role_id == $val1->id) {
                    $val1->status = true;
                }
            }
        }
        return $roles;
    }

    public function get_user_group($user_id) {
        $area_groups = DB::table('area_groups')->get();
        $internal_user_group =  DB::table('user_grouping_pivots')->where('user_id', $user_id)->get();
        foreach($area_groups as $area_group) {
            $area_group->status = false;
        }
        foreach($internal_user_group as $val) {
            foreach($area_groups as $val1) {
                if($val->area_group == $val1->id) {
                    $val1->status = true;
                }
            }
        }
        return $area_groups;
    }

    public function edit_user_roles(Request $request) {
        $request->validate([
            'user_id' => 'required'
        ]);

        $user = User::where('id', $request->user_id)->first();
        $user->roles()->detach();
        $roles_id = array();
        foreach($request->rolesArray['EditRolesArray'] as $role => $value) { 
            if($value == true) {
                $roles_id[] = DB::table('roles')->where('role_name', $role)->first()->id;
            }
        }
        if($roles_id != null) {
            $user->roles()->attach($roles_id);
        }

    }
}
