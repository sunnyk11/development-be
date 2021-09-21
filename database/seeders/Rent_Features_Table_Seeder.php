<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RentFeatures;

class Rent_Features_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RentFeaturesData = [
          
            ['id' => 1,'feature_id' => 'rent-feature-1','feature_name' => 'Multiple Property visit until you are
            100% satisfied','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'feature_id' => 'rent-feature-1','feature_name' => 'Multiple Property visit until you are
            100% satisfied','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 3,'feature_id' => 'rent-feature-1','feature_name' => 'Multiple Property visit until you are
            100% satisfied','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            
            ['id' => 4,'feature_id' => 'rent-feature-2','feature_name' => 'Ready to move','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 5,'feature_id' => 'rent-feature-2','feature_name' => 'Ready to move','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 6,'feature_id' => 'rent-feature-2','feature_name' => 'Ready to move','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 7,'feature_id' => 'rent-feature-3','feature_name' => '100% Money back Guarantee','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 8,'feature_id' => 'rent-feature-3','feature_name' => '100% Money back Guarantee','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 9,'feature_id' => 'rent-feature-3','feature_name' => '100% Money back Guarantee','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 10,'feature_id' => 'rent-feature-4','feature_name' => 'Same day property Handover
            Guarantee','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 11,'feature_id' => 'rent-feature-4','feature_name' => 'Same day property Handover
            Guarantee','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 12,'feature_id' => 'rent-feature-4','feature_name' => 'Same day property Handover
            Guarantee','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 13,'feature_id' => 'rent-feature-5','feature_name' => 'Priority visit slot','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 14,'feature_id' => 'rent-feature-5','feature_name' => 'Priority visit slot','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 15,'feature_id' => 'rent-feature-5','feature_name' => 'Priority visit slot','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 16,'feature_id' => 'rent-feature-6','feature_name' => 'Priority booking of flat','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 17,'feature_id' => 'rent-feature-6','feature_name' => 'Priority booking of flat','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 18,'feature_id' => 'rent-feature-6','feature_name' => 'Priority booking of flat','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 19,'feature_id' => 'rent-feature-7','feature_name' => 'Virtual Live property Visit','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 20,'feature_id' => 'rent-feature-7','feature_name' => 'Virtual Live property Visit','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 21,'feature_id' => 'rent-feature-7','feature_name' => 'Virtual Live property Visit','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 22,'feature_id' => 'rent-feature-8','feature_name' => 'Rent Agreement','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 23,'feature_id' => 'rent-feature-8','feature_name' => 'Rent Agreement','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 24,'feature_id' => 'rent-feature-8','feature_name' => 'Rent Agreement','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'Rs.300 Extra', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 25,'feature_id' => 'rent-feature-9','feature_name' => 'After Sales services','plan_id' => 'Rent-Plan-vvip-1', 'feature_details' => '4 Months vacancy guarantee', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 26,'feature_id' => 'rent-feature-9','feature_name' => 'After Sales services','plan_id' => 'Rent-Plan-vip-2', 'feature_details' => '2 Months vacancy guarantee', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 27,'feature_id' => 'rent-feature-9','feature_name' => 'After Sales services','plan_id' => 'Rent-Plan-regular-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
         ];

         \App\Models\RentFeatures::insert($RentFeaturesData);
    }
}
