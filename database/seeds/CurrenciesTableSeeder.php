<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'name_eng' => 'Euro',
            'name_ru' => 'Евро',
            'code_literal_iso_4217' => 'EUR',
            'code_numeric_iso_4217' => '978',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('currencies')->insert([
            'name_eng' => 'Russian Ruble',
            'name_ru' => 'Российский рубль',
            'code_literal_iso_4217' => 'RUB',
            'code_numeric_iso_4217' => '643',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('currencies')->insert([
            'name_eng' => 'Tenge',
            'name_ru' => 'Тенге',
            'code_literal_iso_4217' => 'KZT',
            'code_numeric_iso_4217' => '398',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('currencies')->insert([
            'name_eng' => 'Turkmenistan New Manat',
            'name_ru' => 'Новый туркменский манат',
            'code_literal_iso_4217' => 'TMT',
            'code_numeric_iso_4217' => '934',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('currencies')->insert([
            'name_eng' => 'US Dollar',
            'name_ru' => 'Доллар США',
            'code_literal_iso_4217' => 'USD',
            'code_numeric_iso_4217' => '840',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);
    }
}
