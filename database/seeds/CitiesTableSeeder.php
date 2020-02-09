<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;
use App\City;
class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'code_crt' => 'МОВ',
            'code_iata' => 'MOW',
            'name_ru' => 'МОСКВА',
            'name_eng' => 'MOSCOW',
            'country_id' => '1',
        ]);
        City::create([
           'code_crt' => 'СПТ',
            'code_iata' => 'LED',
            'name_ru' => 'САНКТ-ПЕТЕРБУРГ',
            'name_eng' => 'ST.PETERSBURG',
            'country_id' => '1',
        ]);
        City::create([
           'code_crt' => 'АШХ',
            'code_iata' => 'ASB',
            'name_ru' => 'АШГАБАТ',
            'name_eng' => 'ASHGABAT',
            'country_id' => '2',
        ]);
    }
}
