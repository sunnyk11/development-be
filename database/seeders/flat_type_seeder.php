<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\flat_type;

class flat_type_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        $property_data = [
          
          ['id' => 1,'name' => '1rk','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'name' => '1bhk','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 3,'name' => '2bhk','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 4,'name' => '3bhk','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 5,'name' => '4bhk','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 6,'name' => '5bhk','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 7,'name' => '6bhk','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
      ];

       \App\Models\flat_type::insert($property_data);
    }
}
