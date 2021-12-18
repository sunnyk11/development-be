<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RentPlans;

class RentPlansTableSeederNew extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RentPlansData = [
          
            ['id' => 1,'plan_name' => 'VVIP','plan_ID' => 'Rent-Plan-vvip-1','payment_type' => 'Advance', 'plan_price' => '20', 'status' => 'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'plan_name' => 'VIP','plan_ID' => 'Rent-Plan-vip-2','payment_type' => 'Advance', 'plan_price' => '15', 'status' => 'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
            
         ];

         \App\Models\RentPlans::insert($RentPlansData);
    }
}
