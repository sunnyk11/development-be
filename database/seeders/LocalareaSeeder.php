<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocalareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $localarea = [
          
            ['id' => 1,'loc_area_id'=>'L01','local_area' => 'Enclave Phase 1','Area_id'=>'470','status' => '1', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 2,'loc_area_id'=>'L02','local_area' => 'Enclave Phase 2','Area_id'=>'470','status' => '1', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
         ];

       \App\Models\localarea::insert($localarea);
    }
}
