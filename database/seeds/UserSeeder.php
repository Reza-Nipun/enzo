<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'info@enzo.fashion',
            'password' => Hash::make('info@enzo.fashion'),
            'status' => 1,  // 0 = Inactive, 1 = Active
            'access_level' => 0,    // 0 = Super Admin, 1 = Admin
        ]);
    }
}
