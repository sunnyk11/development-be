<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenitie;

class AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AmenitieData = [
          
          ['id' => 1,'name' => 'Air Conditioning','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 2,'name' => 'Barbeque','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 3,'name' => 'Dryer','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 4,'name' => 'Gym ','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 5,'name' => 'Laundry','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 6,'name' => 'Lawn','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 7,'name' => 'Microwave','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 8,'name' => 'Outdoor Shower','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 9,'name' => 'Refrigerator','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 10,'name' => 'Sauna','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 11,'name' => 'Swimming Pool','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 12,'name' => 'TV Cable','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 13,'name' => 'Washer','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],
          
          ['id' => 14,'name' => 'WiFi','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 15,'name' => 'Window Coverings','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 16,'name' => 'Wardrobe','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 17,'name' => 'Light','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 18,'name' => 'Beds','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 19,'name' => 'Fan','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 20,'name' => 'Modular Kit','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 21,'name' => 'Fridge','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 22,'name' => 'Ac','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 23,'name' => 'Stove','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 24,'name' => 'Exhaust Fan','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 25,'name' => 'Geyser','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 26,'name' => 'Washing Machine','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 27,'name' => 'Curtains','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 28,'name' => 'Sofa','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 29,'name' => 'Tv','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 30,'name' => 'Water Purified','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],


          ['id' => 31,'name' => 'Chimney','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

          ['id' => 32,'name' => 'Dinning Table','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')],

       ];

       \App\Models\Amenitie::insert($AmenitieData);
    }
}
