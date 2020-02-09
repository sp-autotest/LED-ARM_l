<?php

use Illuminate\Database\Seeder;

class AirlinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('airlines')->insert([
            'code_tkp' => 'T5',
            'aviacompany_name_ru' => 'Гос. национальная служба «Туркменховаёллары»',
            'short_aviacompany_name_ru' => 'Туркменховаёллары',
            'aviacompany_name_eng' => 'Turkmenistan Airlines Company',
            'short_aviacompany_name_eng' => 'Turkmenistan Airlines',
            'code_iata' => 'T5',
            'account_code_iata' => 'T5',
            'account_code_tkp' => '542',
            'city_id' => '3',
            'date_begin_at' => '2001-02-16 20:38:40',
            'date_end_at' => '2201-02-16 20:38:40',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);
    }
}
