<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\moreInfo;

class MoreInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $MoreInfoData = [
          
            ['id' => 1,'more_info' => 'You dont have to pay if you want to change the property with in this time period', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 2,'more_info' => '<strong>Service providers like: </strong><br> Maid
            <br> Laundry Service<br>Water Bottle Supplier<br>Internet Service Provider
            <br>Local Dry Cleaners<br>Grocery Stores Home suppliers<br>Bathroom Cleaner', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
            
            ['id' => 3,'more_info' => 'We will deduct this service charge from the rent which will be paid by the customer to us, and remaining rent amount will be settled to your account.', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],

            ['id' => 4,'more_info' => 'null', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
            
         ];
  
         \App\Models\moreInfo::insert($MoreInfoData);
    }
}
