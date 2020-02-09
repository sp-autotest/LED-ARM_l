<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;

class AirportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('airports')->insert([
            'code_crt' => 'ДМД',
            'code_iata' => 'DME',
            'name_ru' => 'МОСКВА (ДОМОДЕДОВО)',
            'name_eng' => 'MOSCOW (DOMODEDOVO)',
            'city_id' => '1',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('airports')->insert([
            'code_crt' => 'ПЛК',
            'code_iata' => 'LED',
            'name_ru' => 'САНКТ-ПЕТЕРБУРГ (ПУЛКОВО)',
            'name_eng' => 'ST.PETERSBURG (PULKOVO)',
            'city_id' => '2',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('airports')->insert([
            'code_crt' => 'АШХ',
            'code_iata' => 'ASB',
            'name_ru' => 'АШГАБАТ',
            'name_eng' => 'ASHGABAT',
            'city_id' => '3',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);
    }
}
