<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name_ru' => 'Россия',
            'name_eng' => 'Russia',
            'code_iso' => 'RUS',
            'metropolis' => 'МОСКВА',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('countries')->insert([
            'name_ru' => 'Туркменистан',
            'name_eng' => 'Turkmenistan',
            'code_iso' => 'TKM',
            'metropolis' => 'АШГАБАТ',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);
    }
}
