<?php

use Illuminate\Database\Seeder;

class Types_feesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_fees')->insert([
            'name_eng' => 'Avia',
            'name_ru' => 'Авиа',
			'date_of_start' => '2001-01-01',
            'date_of_stop' => '2101-01-01',
			'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);	 

    }
}