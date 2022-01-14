<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Role;
use App\Models\Permission;

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
            'roleName' => 'required'
        ]);

        $role = new Role([
            'role_name' => $request->roleName
        ]);
        
        $result = $role->save();

        //return $request->permissionsArray;
        //return gettype($request->permissionsArray);
        foreach($request->permissionsArray as $permission => $value) {
            if($value == true) {
                $permission_id[] = DB::table('permissions')->where('permission_name', $permission)->first()->id;
            }
        }
        //return $permission_id;
        $role->permissions()->attach($permission_id);
        //$permissions = DB::table('permissions')->get();
        
        //return $result;

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

        foreach($request->permissionsArray['EditPermissionsArray'] as $permission => $value) { 
            if($value == true) {
                $permission_id[] = DB::table('permissions')->where('permission_name', $permission)->first()->id;
            }
        }
        $role->permissions()->attach($permission_id);
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
}
