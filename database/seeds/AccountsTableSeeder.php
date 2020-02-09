<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'company_registry_id' => '1',
            'account_number' => '1',
            'payment_terms' => 'aaa',
            'credit_limit' => '0',
            'balance' => '2897',
            'created_id' => '1',
            'updated_id' => '1',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40'
        ]);

    }
}
