<?php

namespace Database\Seeders;
use App\Models\property_ageement_duration;

use Illuminate\Database\Seeder;

class ageement_duration extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ageement_duration = [
          
          ['id' => 1,'name' => 'One Year','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'name' => 'Three Years','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 3,'name' => 'Custom','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

       ];

       \App\Models\property_ageement_duration::insert($ageement_duration);
    }
}
