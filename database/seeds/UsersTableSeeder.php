<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'id' => '1',
            'company_id' => '1',
            'active' => 'true',
            'email' => 'admin@admin.com',
            'email_verified_at' => '2001-02-16 20:38:40',
            'password' => bcrypt('ROMEISFARE'),
            'remember_token' => 'ek4RYgaRDs0CuDChbG8YbPhnjZhYV8d0RX1vg4jYJZw2d2STNXuuoMYZ6fw4',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40',           
            'last_login_ip' => '0.0.0.0',
            'last_login_at' => '2001-02-16 20:38:40',
            'is_admin' => '1'
        ]);

            }
}

