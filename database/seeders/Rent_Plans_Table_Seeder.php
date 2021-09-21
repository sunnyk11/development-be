<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RentPlans;

class Rent_Plans_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RentPlansData = [
          
            ['id' => 1,'plan_name' => 'VVIP','plan_ID' => 'Rent-Plan-vvip-1','payment_type' => 'Advance', 'plan_price' => '30', 'status' => 'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'plan_name' => 'VIP','plan_ID' => 'Rent-Plan-vip-2','payment_type' => 'Advance', 'plan_price' => '15', 'status' => 'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 3,'plan_name' => 'Regular','plan_ID' => 'Rent-Plan-regular-3','payment_type' => 'Post', 'plan_price' => '15', 'status' => 'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
         ];

         \App\Models\RentPlans::insert($RentPlansData);
    }
}
