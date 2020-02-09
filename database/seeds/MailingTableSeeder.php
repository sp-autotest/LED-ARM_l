<?php

use Illuminate\Database\Seeder;

class MailingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('mailing')->insert([
'status' => 'true',
'type_mailing' => '1',
'company_registry_id' => '1',
'created_id' => '1',
'updated_id' => '1',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40',
'company_registry_id' => '1'
]);
        
            DB::table('mailing')->insert([
'status' => 'true',
'type_mailing' => '2',
'company_registry_id' => '1',
'created_id' => '1',
'updated_id' => '1',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40',
'company_registry_id' => '1'
]);
        
            DB::table('mailing')->insert([
'status' => 'true',
'type_mailing' => '3',
'company_registry_id' => '1',
'created_id' => '1',
'updated_id' => '1',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40',
'company_registry_id' => '1'
]);
        
            DB::table('mailing')->insert([
'status' => 'true',
'type_mailing' => '4',
'company_registry_id' => '1',
'created_id' => '1',
'updated_id' => '1',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40',
'company_registry_id' => '1'
]);
        
            DB::table('mailing')->insert([
'status' => 'true',
'type_mailing' => '2',
'company_registry_id' => '5',
'created_id' => '1',
'updated_id' => '1',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40',
'company_registry_id' => '1'
]);
        
            DB::table('mailing')->insert([
'status' => 'true',
'type_mailing' => '2',
'company_registry_id' => '1',
'created_id' => '1',
'updated_id' => '1',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40',
'company_registry_id' => '6'
]);
    }
}
