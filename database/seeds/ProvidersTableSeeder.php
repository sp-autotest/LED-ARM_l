<?php

use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('providers')->insert([
            'name_ru' => 'Crane Aero',
            'name_full_ru' => 'Crane Aero Ltd (Itm)',
            'name_eng' => 'Crane Aero',
            'name_full_eng' => 'Crane Aero Ltd (Itm)',
            'date_begin_at' => '2019-01-01 00:00:00',
            'date_end_at' => '2029-12-31 23:59:59',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);
        DB::table('providers')->insert([
            'name_ru' => 'Блоки',
            'name_full_ru' => 'ITM System',
            'name_eng' => 'ITM',
            'name_full_eng' => 'ITM System Ltd',
            'date_begin_at' => '2019-01-01 00:00:00',
            'date_end_at' => '2029-12-31 23:59:59',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
         ]);
    }
}
