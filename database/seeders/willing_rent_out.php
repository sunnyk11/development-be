<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\property_willing_rent_out;

class willing_rent_out extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $willing_rent_out = [
          
          ['id' => 1,'name' => 'Family','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'name' => 'Single Men','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 3,'name' => 'Single Women','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

       ];

       \App\Models\property_willing_rent_out::insert($willing_rent_out);
    }
}
