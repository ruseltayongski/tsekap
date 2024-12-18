<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call('FacilitiesTableSeeder');
         $this->call(UserSeeder::class);
         $this->call(LocationSeeder::class);
         $this->call(caseSeeder::class);
         $this->call(BracketServiceSeeder::class);
    }
}
