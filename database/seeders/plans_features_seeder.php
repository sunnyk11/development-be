<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\plansFeatures;

class plans_features_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plansFeatures = [
          
            ['id' => 1,'feature_name' => 'Payment Type','feature_details' => 'Advance','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 2,'feature_name' => 'Payment Type','feature_details' => 'Pay Later','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'1','more_info_id'=>3,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 3,'feature_name' => 'Free Property Change','feature_details' => 'With in 6 months','feature_value' => '6', 'feature_value_text' => 'months','more_info_status'=>'1','more_info_id'=>1,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 4,'feature_name' => 'Free Property Change','feature_details' => 'With in 5 months','feature_value' => '5', 'feature_value_text' => 'months','more_info_status'=>'1','more_info_id'=>1,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 5,'feature_name' => 'Free Property Change','feature_details' => 'With in 4 months','feature_value' => '4', 'feature_value_text' => 'months','more_info_status'=>'1','more_info_id'=>1,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 6,'feature_name' => 'Free Property Change','feature_details' => 'With in 3 months','feature_value' => '3', 'feature_value_text' => 'months','more_info_status'=>'1','more_info_id'=>1,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 7,'feature_name' => 'Free Property Change','feature_details' => 'With in 2 months','feature_value' => '2', 'feature_value_text' => 'months','more_info_status'=>'1','more_info_id'=>1,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 8,'feature_name' => 'Free Property Change','feature_details' => 'With in 1 months','feature_value' => '1', 'feature_value_text' => 'months','more_info_status'=>'1','more_info_id'=>1,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 9,'feature_name' => 'Free Property Change','feature_details' => 'no','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'1','more_info_id'=>2,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 10,'feature_name' => 'No.of  time property will be changed','feature_details' => '5 Times','feature_value' => '5', 'feature_value_text' => 'Times','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 11,'feature_name' => 'No.of  time property will be changed','feature_details' => '4 Times','feature_value' => '4', 'feature_value_text' => 'Times','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 12,'feature_name' => 'No.of  time property will be changed','feature_details' => '3 Times','feature_value' => '3', 'feature_value_text' => 'Times','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 13,'feature_name' => 'No.of  time property will be changed','feature_details' => '2 Times','feature_value' => '2', 'feature_value_text' => 'Times','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 14,'feature_name' => 'No.of  time property will be changed','feature_details' => '1 Times','feature_value' => '1', 'feature_value_text' => 'Times','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 15,'feature_name' => 'No.of  time property will be changed','feature_details' => 'no','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 16,'feature_name' => 'After Sales support (Personal Relationship ','feature_details' => '6 months','feature_value' => '6', 'feature_value_text' => 'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 17,'feature_name' => 'After Sales support (Personal Relationship ','feature_details' => '5 months','feature_value' => '5', 'feature_value_text' => 'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 18,'feature_name' => 'After Sales support (Personal Relationship ','feature_details' => '4 months','feature_value' => '4', 'feature_value_text' => 'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 19,'feature_name' => 'After Sales support (Personal Relationship ','feature_details' => '3 months','feature_value' => '3', 'feature_value_text' => 'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 20,'feature_name' => 'After Sales support (Personal Relationship ','feature_details' => '2 months','feature_value' => '2', 'feature_value_text' => 'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 21,'feature_name' => 'After Sales support (Personal Relationship ','feature_details' => '1 months','feature_value' => '1', 'feature_value_text' => 'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 22,'feature_name' => 'After Sales support (Personal Relationship ','feature_details' => 'no','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 23,'feature_name' => 'Local Area Service Provider List Access','feature_details' => 'yes','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'1','more_info_id'=>2,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            ['id' => 24,'feature_name' => 'Local Area Service Provider List Access','feature_details' => 'no','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'1','more_info_id'=>2,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 25,'feature_name' => 'Rent Agreement','feature_details' => 'Free','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 26,'feature_name' => 'Property will be let out','feature_details' => 'within 30 days','feature_value' => '30', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 27,'feature_name' => 'Property will be let out','feature_details' => 'within 45 days','feature_value' => '45', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 28,'feature_name' => 'Property will be let out','feature_details' => 'within 60 days','feature_value' => '60', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 29,'feature_name' => 'Property will be let out','feature_details' => 'within 75 days','feature_value' => '75', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 30,'feature_name' => 'Property will be let out','feature_details' => 'within 90 days','feature_value' => '90', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 31,'feature_name' => 'Money Back Guarantee','feature_details' => '100% if property is not let out in 30 days','feature_value' => '30', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 32,'feature_name' => 'Money Back Guarantee','feature_details' => '100% if property is not let out in 45 days','feature_value' => '45', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 33,'feature_name' => 'Money Back Guarantee','feature_details' => '100% if property is not let out in 60 days','feature_value' => '60', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 34,'feature_name' => 'Money Back Guarantee','feature_details' => '100% if property is not let out in 75 days','feature_value' => '75', 'feature_value_text' => 'days','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 35,'feature_name' => 'Money Back Guarantee','feature_details' => 'no','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],



            ['id' => 36,'feature_name' => 'Client Visit Priority','feature_details' => '1st','feature_value' => '1', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 37,'feature_name' => 'Client Visit Priority','feature_details' => '2nd','feature_value' => '2', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 38,'feature_name' => 'Client Visit Priority','feature_details' => '3rd','feature_value' => '3', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 39,'feature_name' => 'Client Visit Priority','feature_details' => '4th','feature_value' => '4', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 40,'feature_name' => 'Free property letout if your property is vacated','feature_details' => 'within 6 months','feature_value' => '6', 'feature_value_text' =>'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 41,'feature_name' => 'Free property letout if your property is vacated','feature_details' => 'within 5 months','feature_value' => '5', 'feature_value_text' =>'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 42,'feature_name' => 'Free property letout if your property is vacated','feature_details' => 'within 4 months','feature_value' => '4', 'feature_value_text' =>'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 43,'feature_name' => 'Free property letout if your property is vacated','feature_details' => 'within 3 months','feature_value' => '3', 'feature_value_text' =>'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 44,'feature_name' => 'Free property letout if your property is vacated','feature_details' => 'within 2 months','feature_value' => '2', 'feature_value_text' =>'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 45,'feature_name' => 'Free property letout if your property is vacated','feature_details' => 'within 1 months','feature_value' => '1', 'feature_value_text' =>'months','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 46,'feature_name' => 'Free property letout if your property is vacated','feature_details' => 'no','feature_value' => '0', 'feature_value_text' =>'','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 47,'feature_name' => 'No.of  time property will be let out','feature_details' => '3 Times','feature_value' => '3', 'feature_value_text' => 'Times','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 48,'feature_name' => 'No.of  time property will be let out','feature_details' => '2 Times','feature_value' => '2', 'feature_value_text' => 'Times','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 49,'feature_name' => 'No.of  time property will be let out','feature_details' => '1 Times','feature_value' => '1', 'feature_value_text' => 'Times','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 50,'feature_name' => 'No.of  time property will be let out','feature_details' => 'no','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 51,'feature_name' => 'Free Property Measurement','feature_details' => 'yes','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 52,'feature_name' => 'Free Photo Clicks','feature_details' => 'yes','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 53,'feature_name' => 'Personal Relationship Officer','feature_details' => 'yes','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 54,'feature_name' => 'Personal Relationship Officer','feature_details' => 'no','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 55,'feature_name' => 'Verified Property Tag','feature_details' => 'yes','feature_value' => '0', 'feature_value_text' => '','more_info_status'=>'0','more_info_id'=>4,'status'=>'enabled', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
         ];

         \App\Models\plansFeatures::insert($plansFeatures);
    }
}
