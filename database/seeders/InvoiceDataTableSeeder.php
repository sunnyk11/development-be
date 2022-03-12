<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoiceData;

class InvoiceDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Data = [
          
            ['id' => 1,'gstin' => '07AAFCH3754A1ZX','pan_no' => 'AAFCH3754A','mobile_no' => '9818954521', 'email' => 'support@housingstreet.com', 'website_address' => 'www.housingstreet.com', 'address' => 'House No B-165 Ambedkar Colony, Gali No-1, Chattarpur, New Delhi - 110074', 'cin' => 'U67100DL2020PTC367725', 'sac' => '9972', 'sgst' => '9', 'cgst' => '9', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
         ];

         \App\Models\InvoiceData::insert($Data);
    }
}
