<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            'avatar' => 'user-1.jpg',
            'user_id' => '1',
            'first_name' => 'admin',
            'second_name' => 'admin',
            'middle_name' => 'admin',
            'phone' => '+00000000000',
            'additional_phone' => '+00000000000',
            'additional_email' => 'admin@admin.com',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40',
            'sex' => 'true',
            'position' => '1'
        ]);
    }
}
