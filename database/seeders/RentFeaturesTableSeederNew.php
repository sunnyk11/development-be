<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RentFeatures;

class RentFeaturesTableSeederNew extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RentFeaturesData = [
          
            ['id' => 1,'feature_id' => 'rent-feature-1','feature_name' => 'Payment Type','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'Advance', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'feature_id' => 'rent-feature-1','feature_name' => 'Payment Type','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'Advance', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            
            ['id' => 3,'feature_id' => 'rent-feature-2','feature_name' => 'Free Property Change','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => '5 Months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 4,'feature_id' => 'rent-feature-2','feature_name' => 'Free Property Change','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => '2 Months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            


            ['id' => 5,'feature_id' => 'rent-feature-3','feature_name' => 'After Sales Support (Personal Relationship Officer)','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => '5 Months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 6,'feature_id' => 'rent-feature-3','feature_name' => 'After Sales Support (Personal Relationship Officer)','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => '2 Months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 7,'feature_id' => 'rent-feature-4','feature_name' => 'Local Area Service Provider List Access','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 8,'feature_id' => 'rent-feature-4','feature_name' => 'Local Area Service Provider List Access','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
        


            ['id' => 9,'feature_id' => 'rent-feature-5','feature_name' => 'Rent Agreement','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 10,'feature_id' => 'rent-feature-5','feature_name' => 'Rent Agreement','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            
         ];

         \App\Models\RentFeatures::insert($RentFeaturesData);
    }
}
