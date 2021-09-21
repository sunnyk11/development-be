<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetOutPlans;

class LetOut_Plans_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $LetOutPlansData = [
          
            ['id' => 1,'plan_name' => 'Maha Raja','plan_ID' => 'LetOut-Plan-MahaRaja-1','payment_type' => 'Advance', 'plan_price' => '30', 'status' => 'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'plan_name' => 'Raja','plan_ID' => 'LetOut-Plan-Raja-2','payment_type' => 'Advance', 'plan_price' => '15', 'status' => 'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 3,'plan_name' => 'Standard','plan_ID' => 'LetOut-Plan-Standard-3','payment_type' => 'Post', 'plan_price' => '15', 'status' => 'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
         ];

         \App\Models\LetOutPlans::insert($LetOutPlansData);
    }
}
