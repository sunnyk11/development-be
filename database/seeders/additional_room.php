<?php

namespace Database\Seeders;
use App\Models\property_room;

use Illuminate\Database\Seeder;

class additional_room extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
         $property_room = [
          
          ['id' => 1,'name' => 'Pooja  Room','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'name' => 'Study  Room','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 3,'name' => 'Servant  Room','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 4,'name' => 'Other  Room','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

       ];

       \App\Models\property_room::insert($property_room);
    }
}
