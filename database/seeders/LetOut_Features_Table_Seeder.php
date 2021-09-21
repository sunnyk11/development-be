<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetOutFeatures;

class LetOut_Features_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $LetOutFeaturesData = [
          
            ['id' => 1,'feature_id' => 'letout-feature-1','feature_name' => 'Rent Agreement','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'feature_id' => 'letout-feature-1','feature_name' => 'Rent Agreement','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 3,'feature_id' => 'letout-feature-1','feature_name' => 'Rent Agreement','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'Free', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 4,'feature_id' => 'letout-feature-2','feature_name' => 'Photo Clicks','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 5,'feature_id' => 'letout-feature-2','feature_name' => 'Photo Clicks','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 6,'feature_id' => 'letout-feature-2','feature_name' => 'Photo Clicks','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 7,'feature_id' => 'letout-feature-3','feature_name' => 'Video Shoot','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 8,'feature_id' => 'letout-feature-3','feature_name' => 'Video Shoot','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 9,'feature_id' => 'letout-feature-3','feature_name' => 'Video Shoot','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 10,'feature_id' => 'letout-feature-4','feature_name' => 'Property Measurement','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 11,'feature_id' => 'letout-feature-4','feature_name' => 'Property Measurement','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 12,'feature_id' => 'letout-feature-4','feature_name' => 'Property Measurement','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 13,'feature_id' => 'letout-feature-5','feature_name' => 'Refund Guarantee','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => '110% if not let out in 30 days', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 14,'feature_id' => 'letout-feature-5','feature_name' => 'Refund Guarantee','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => '100% if not let out in 45 days', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 15,'feature_id' => 'letout-feature-5','feature_name' => 'Refund Guarantee','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 16,'feature_id' => 'letout-feature-6','feature_name' => 'No Questions asked money back
            Guarantee','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 17,'feature_id' => 'letout-feature-6','feature_name' => 'No Questions asked money back
            Guarantee','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 18,'feature_id' => 'letout-feature-6','feature_name' => 'No Questions asked money back
            Guarantee','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 19,'feature_id' => 'letout-feature-7','feature_name' => 'Vacancy Zero Cost','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => '4 Months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 20,'feature_id' => 'letout-feature-7','feature_name' => 'Vacancy Zero Cost','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => '2 Months', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 21,'feature_id' => 'letout-feature-7','feature_name' => 'Vacancy Zero Cost','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 22,'feature_id' => 'letout-feature-8','feature_name' => 'End to End Support','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 23,'feature_id' => 'letout-feature-8','feature_name' => 'End to End Support','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 24,'feature_id' => 'letout-feature-8','feature_name' => 'End to End Support','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 25,'feature_id' => 'letout-feature-9','feature_name' => 'Verified Property Tag','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 26,'feature_id' => 'letout-feature-9','feature_name' => 'Verified Property Tag','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 27,'feature_id' => 'letout-feature-9','feature_name' => 'Verified Property Tag','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 28,'feature_id' => 'letout-feature-10','feature_name' => 'Display Property on Top','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 29,'feature_id' => 'letout-feature-10','feature_name' => 'Display Property on Top','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 30,'feature_id' => 'letout-feature-10','feature_name' => 'Display Property on Top','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 31,'feature_id' => 'letout-feature-11','feature_name' => 'Personal Relationship Officer','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 32,'feature_id' => 'letout-feature-11','feature_name' => 'Personal Relationship Officer','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 33,'feature_id' => 'letout-feature-11','feature_name' => 'Personal Relationship Officer','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],


            ['id' => 34,'feature_id' => 'letout-feature-12','feature_name' => 'Priority Client Visit','plan_id' => 'LetOut-Plan-MahaRaja-1', 'feature_details' => 'yes', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 35,'feature_id' => 'letout-feature-12','feature_name' => 'Priority Client Visit','plan_id' => 'LetOut-Plan-Raja-2', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 36,'feature_id' => 'letout-feature-12','feature_name' => 'Priority Client Visit','plan_id' => 'LetOut-Plan-Standard-3', 'feature_details' => 'no', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            
         ];

         \App\Models\LetOutFeatures::insert($LetOutFeaturesData);
    }
}
