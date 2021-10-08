<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        $this->call(AmenitiesSeeder::class);
        $this->call(Property_typeSeeder::class);
        $this->call(User_Roles_Table_Seeder::class);
        $this->call(Rent_Plans_Table_Seeder::class);
        $this->call(LetOut_Plans_Table_Seeder::class);
        $this->call(Rent_Features_Table_Seeder::class);
        $this->call(LetOut_Features_Table_Seeder::class);
        $this->call(LocalareaSeeder::class);
    }
}
