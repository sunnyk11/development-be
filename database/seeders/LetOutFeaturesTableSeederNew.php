<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetOutFeatures;

class LetOutFeaturesTableSeederNew extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $LetOutFeaturesData = [
          
            ['id' => 1,'feature_id' => 'letout-feature-1','feature_name' => 'Payment Type','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'Advance', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'feature_id' => 'letout-feature-1','feature_name' => 'Payment Type','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'Advance', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 3,'feature_id' => 'letout-feature-1','feature_name' => 'Payment Type','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'Pay Later', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 4,'feature_id' => 'letout-feature-2','feature_name' => 'Property will be let out','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'Within 30 days', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 5,'feature_id' => 'letout-feature-2','feature_name' => 'Property will be let out','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'Within 45 days', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 6,'feature_id' => 'letout-feature-2','feature_name' => 'Property will be let out','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'Within 60 days', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 7,'feature_id' => 'letout-feature-3','feature_name' => 'Money Back Guarantee','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => '100% if property is not let out in 30 days', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 8,'feature_id' => 'letout-feature-3','feature_name' => 'Money Back Guarantee','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => '100% if property is not let out in 45 days', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 9,'feature_id' => 'letout-feature-3','feature_name' => 'Money Back Guarantee','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 10,'feature_id' => 'letout-feature-4','feature_name' => 'Client Visit Priority','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => '1st', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 11,'feature_id' => 'letout-feature-4','feature_name' => 'Client Visit Priority','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => '2nd', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 12,'feature_id' => 'letout-feature-4','feature_name' => 'Client Visit Priority','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => '3rd', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 13,'feature_id' => 'letout-feature-5','feature_name' => 'Free Property Let Out if your property is vacated','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'within 6 months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 14,'feature_id' => 'letout-feature-5','feature_name' => 'Free Property Let Out if your property is vacated','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'within 3 months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 15,'feature_id' => 'letout-feature-5','feature_name' => 'Free Property Let Out if your property is vacated','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'within 2 months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 16,'feature_id' => 'letout-feature-6','feature_name' => 'Local Area Service Provider List Access','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 17,'feature_id' => 'letout-feature-6','feature_name' => 'Local Area Service Provider List Access','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 18,'feature_id' => 'letout-feature-6','feature_name' => 'Local Area Service Provider List Access','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 19,'feature_id' => 'letout-feature-7','feature_name' => 'Free Property Measurement','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 20,'feature_id' => 'letout-feature-7','feature_name' => 'Free Property Measurement','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 21,'feature_id' => 'letout-feature-7','feature_name' => 'Free Property Measurement','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 22,'feature_id' => 'letout-feature-8','feature_name' => 'Free Photo Clicks','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 23,'feature_id' => 'letout-feature-8','feature_name' => 'Free Photo Clicks','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 24,'feature_id' => 'letout-feature-8','feature_name' => 'Free Photo Clicks','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 25,'feature_id' => 'letout-feature-9','feature_name' => 'Personal Relationship Officer','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 26,'feature_id' => 'letout-feature-9','feature_name' => 'Personal Relationship Officer','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 27,'feature_id' => 'letout-feature-9','feature_name' => 'Personal Relationship Officer','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 28,'feature_id' => 'letout-feature-10','feature_name' => 'Verified Property Tag','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 29,'feature_id' => 'letout-feature-10','feature_name' => 'Verified Property Tag','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 30,'feature_id' => 'letout-feature-10','feature_name' => 'Verified Property Tag','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 31,'feature_id' => 'letout-feature-11','feature_name' => 'Rent Agreement','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 32,'feature_id' => 'letout-feature-11','feature_name' => 'Rent Agreement','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 33,'feature_id' => 'letout-feature-11','feature_name' => 'Rent Agreement','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            
         ];

         \App\Models\LetOutFeatures::insert($LetOutFeaturesData);
    }
}
