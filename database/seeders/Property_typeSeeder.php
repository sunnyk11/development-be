<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property_type;

class Property_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $property_data = [
          
          ['id' => 1,'name' => 'Flat/ Apartment','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'name' => 'Residential House','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 3,'name' => 'Villa','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 4,'name' => 'Builder Floor Apartment ','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 5,'name' => 'Residential Land/ Plot','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 6,'name' => 'Penthouse','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 7,'name' => 'Studio Apartment','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 8,'name' => 'Commercial Office Space','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 9,'name' => 'Office in IT Park/ SEZ','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 10,'name' => 'Commercial Shop','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 11,'name' => 'Commercial Showroom','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 12,'name' => 'Commercial Land','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 13,'name' => 'Warehouse/ Godown','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 14,'name' => 'Industrial Land','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 15,'name' => 'Industrial Building','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 16,'name' => 'Industrial Shed ','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 17,'name' => 'Agricultural Land','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 18,'name' => 'Farm House','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

       ];

       \App\Models\Property_type::insert($property_data);
   
    }
}
