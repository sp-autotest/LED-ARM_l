<?php

use Illuminate\Database\Seeder;

class Fare_familiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fare_families')->insert([
            'code' => 'C12OW',
            'name_eng' => 'BUSINESS',
            'name_ru' => 'Бизнес',
            'luggage_adults' => '50',
            'luggage_children' => '30',
            'luggage_infants' => '0',
            'max_stay' => '2',
            'note_fare' => 'Приоритетная посадка Не предоставляется            
Приоритетная выдача багажа Не предоставляется
Выделенная стойка регистрации Предоставляется специально обозначенная стойка в зоне класса Эконом или стойка в зоне Sky Priority
Доступ в зал ожидания повышенной комфортности Не предоставляется',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40',
            'fare_families_group' => '1',
        ]);

        DB::table('fare_families')->insert([
            'code' => 'Y12OW',
            'name_eng' => 'ECONOMY',
            'name_ru' => 'Эконом',
            'luggage_adults' => '30',
            'luggage_children' => '20',
            'luggage_infants' => '0',
            'max_stay' => '5',
            'note_fare' => 'Выделенная стойка регистрации Предоставляется специально обозначенная стойка в зоне Sky Priority
            Доступ в зал ожидания повышенной комфортности Предоставляется',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40',
            'fare_families_group' => '2',
        ]);
    }
}
