<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            'fname' => 'Jimmy',
//            'mname' => 'Baron',
//            'lname' => 'Lomocso',
//            'username' => 'admin',
//            'muncity' => '63',
//            'province' => '2',
//            'password' => bcrypt('admin'),
//            'user_priv' => 1
//        ]);

        DB::table('users')->insert([
            'fname' => 'DOH',
            'mname' => '',
            'lname' => 'REGION VII',
            'username' => 'admin',
            'muncity' => '63',
            'province' => '1',
            'password' => bcrypt('admin'),
            'contact' => '09162072427',
            'user_priv' => 1
        ]);
    }
}
