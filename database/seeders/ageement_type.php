<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\property_ageement_type;

class ageement_type extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ageement_type = [
          
          ['id' => 1,'name' => 'Company Lease Agreement','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'name' => 'Any','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
       ];

       \App\Models\property_ageement_type::insert($ageement_type);
    }
}
