<?php

use Illuminate\Database\Seeder;

class Bc_typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bc_types')->insert([
            'name_ru' => 'Боинг 737-800',
            'name_eng' => 'Boeing 737-800',
            'aircraft_class_code' => 'B737-800',
            'ccp' => '16C/144Y[1]',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('bc_types')->insert([
            'name_ru' => 'Боинг 777-300ER',
            'name_eng' => 'Boeing 777-300ER',
            'aircraft_class_code' => 'B777-300ER',
            'ccp' => '30C/48W(Comfort)/324Y',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('bc_types')->insert([
            'name_ru' => 'Аэробус А321 (бизнес)',
            'name_eng' => 'Airbus А321 (business)',
            'aircraft_class_code' => 'А321B',
            'ccp' => '28C/142Y',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

        DB::table('bc_types')->insert([
            'name_ru' => 'Аэробус А321 (эконом)',
            'name_eng' => 'Airbus А321 (econom)',
            'aircraft_class_code' => 'А321E',
            'ccp' => '16C/167Y',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);
    }
}
