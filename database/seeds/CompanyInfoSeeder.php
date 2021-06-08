<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_infos')->insert([
            'company_name' => 'ENZO',
            'company_email' => 'info@enzo.fashion',
        ]);
    }
}
