<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class User_Roles_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $UserRoleData = [
          
            ['id' => 1,'role' => 'Manager','role_id' => '611d462550be7-2','access_all_users' => '0', 'access_properties' => '1', 'access_reviews' => '1', 'access_lawyer_services' => '1', 'access_loan_control' => '0', 'access_user_creator' => '0', 'access_manage_blog' => '1', 'access_manage_roles' => '1', 'access_list_property' => '1', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'role' => 'Branch Manager','role_id' => '611d466164b1c-4','access_all_users' => '1', 'access_properties' => '0', 'access_reviews' => '0', 'access_lawyer_services' => '0', 'access_loan_control' => '1', 'access_user_creator' => '0', 'access_manage_blog' => '0', 'access_manage_roles' => '0', 'access_list_property' => '1', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 3,'role' => 'Branch Relationship Officer','role_id' => '611d467d6716c-5','access_all_users' => '1', 'access_properties' => '0', 'access_reviews' => '0', 'access_lawyer_services' => '1', 'access_loan_control' => '0', 'access_user_creator' => '1', 'access_manage_blog' => '0', 'access_manage_roles' => '0', 'access_list_property' => '0', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 4,'role' => 'Admin','role_id' => '611d444ecc656-1','access_all_users' => '1', 'access_properties' => '1', 'access_reviews' => '1', 'access_lawyer_services' => '1', 'access_loan_control' => '1', 'access_user_creator' => '1', 'access_manage_blog' => '1', 'access_manage_roles' => '1', 'access_list_property' => '1', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
  
         ];
  
         \App\Models\UserRole::insert($UserRoleData);
    }
}
