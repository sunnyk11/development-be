<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\property_maintenance_conditions;

class maintenance_condition extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $maintenance_condition = [
          
          ['id' => 1,'name' => 'Monthly','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'name' => 'Annually','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 3,'name' => 'One Time','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
       ];

       \App\Models\property_maintenance_condition::insert($maintenance_condition);
    }
}
