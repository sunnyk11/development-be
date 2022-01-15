<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class area_unit extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $area_unit = [
          
          ['id' => 1,'unit' => 'sq.ft.','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'unit' => 'sq.yards','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 3,'unit' => 'sq.m.','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 4,'unit' => 'acres','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 5,'unit' => 'marla','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 6,'unit' => 'cents','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 7,'unit' => 'bigha','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 8,'unit' => 'kottah','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 9,'unit' => 'kanal','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 10,'unit' => 'grounds','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 11,'unit' => 'biswa','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 12,'unit' => 'guntha','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 13,'unit' => 'aankadam','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 14,'unit' => 'hectares','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 15,'unit' => 'rood','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 16,'unit' => 'chataks ','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 17,'unit' => 'perch','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

       ];

       \App\Models\area_unit::insert($area_unit);
   
    }
}
