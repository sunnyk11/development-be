<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class permissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $PermissionsData = [
          
            //  ['id' => 1,'permission_name' => 'access_all_users', 'slug' => 'all_users', 'description' => 'All Users', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            // ['id' => 2,'permission_name' => 'access_reviews', 'slug' => 'reviews', 'description' => 'Reviews', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            // ['id' => 3,'permission_name' => 'access_user_creator', 'slug' => 'user_creator', 'description' => 'User Creator', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            // ['id' => 4,'permission_name' => 'access_manage_blog', 'slug' => 'manage_blog', 'description' => 'Manage Blog', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            // ['id' => 5,'permission_name' => 'access_manage_roles', 'slug' => 'manage_roles', 'description' => 'Manage Roles', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            // ['id' => 6,'permission_name' => 'access_property_location', 'slug' => 'property_location', 'description' => 'Property Location', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            // ['id' => 7,'permission_name' => 'access_search_bar', 'slug' => 'search_bar', 'description' => 'Search Bar', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            // ['id' => 8,'permission_name' => 'access_other_details', 'slug' => 'other_details', 'description' => 'Other Details', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            // ['id' => 9,'permission_name' => 'access_manage_plans', 'slug' => 'manage_plans', 'description' => 'Manage Plans', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            // ['id' => 10,'permission_name' => 'access_local_area_service_provider', 'slug' => 'local_area_service_provider', 'description' => 'Local Area Service Provider', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')], 

            // ['id' => 11,'permission_name' => 'access_bank_details', 'slug' => 'bank_details', 'description' => 'Bank Details', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            // ['id' => 12,'permission_name'=>'access_create_userbyinternal', 'slug' => 'create_userByinternal', 'description' => 'Create User By internal', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')], 

            // ['id' => 13,'permission_name' => 'access_view_userByinternal', 'slug' => 'view_userByinternal', 'description' => 'View User By internal', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')], 

            // ['id' => 14,'permission_name' => 'access_update_userByinternal', 'slug' => 'update_userByinternal', 'description' => 'Update User By internal', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')], 

            // ['id' => 15,'permission_name' => 'access_delete_userByinternal', 'slug' => 'delete_userByinternal', 'description' => 'Delete User By internal', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
            // ['id' => 16,'permission_name' => 'access_web_Banner', 'slug' => 'access_web_Banner', 'description' => 'Access Web banner', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
             // ['id' => 17,'permission_name' => 'property_access', 'slug' => 'property_access', 'description' => 'Web Property Access ', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
             ['id' => 18,'permission_name' => 'access_locality_area', 'slug' => 'access_locality_area', 'description' => 'Property Area Location Access ', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
         ];
  
         \App\Models\Permission::insert($PermissionsData);
    }
}
