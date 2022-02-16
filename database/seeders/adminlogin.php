<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;

class adminlogin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_data = [
          
            [
                'name'=>'Super Admin',
                'last_name'=> 'Super Admin',
                'gender' =>'Male',
                'email'=>'admin@gmail.com',
                'usertype'=>11,
                'userSelect_type'=>11,
                'other_mobile_number'=>'9988776655',
                'phone_number_verification_status'=>1,
                'internal_user'=>'No',
                'password' => bcrypt('12345678'),
                'user_role' => 'Admin',
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')],
         ];
         
       \App\Models\User::insert($admin_data);
    }
}
