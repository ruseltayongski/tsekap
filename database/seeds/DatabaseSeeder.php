<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // Execute composer dump-autoload
    // Exceute next: php artisan db:seed --class=FacilitiesTableSeeder
    
    public function run()
    {
         $this->call(FacilitiesTableSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(LocationSeeder::class);
         $this->call(caseSeeder::class);
         $this->call(BracketServiceSeeder::class);
    }
}