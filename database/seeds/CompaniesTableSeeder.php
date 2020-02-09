<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'company_name' => 'ITM System',
            'legal_company_name' => 'ITM System Ltd',
            'post_address' => 'Проспект Ленина, 66',
            'legal_address' => 'Проспект Ленина, 155',
			'city' => 'London',
			'phone' => '+7 495 587-42-05',
			'finance_mail' => 'ad@meduza.io',
			'report_mail' => 'ad@meduza.ru',
			'logo' => '1552537278.png',
			'fax' => '+74954521445',
			'currency_id' => '2',
			'okud' => '45286565000',
			'inn' => '7712040126',
			'okonh' => '155',
            'created_id' => '1',
            'updated_id' => '1',
            'created_at' => '2001-02-16 20:38:40',
            'updated_at' => '2001-02-16 20:38:40',
			'kpp' => '770401001',
			'ogrn' => '1027700092661',
			'bank_name' => 'Alfa',
			'сhecking_account' => '155',
			'bik' => '044525593',
			'correspondent_account' => '30101810200000000593',
			'first_name' => 'Vova',
			'second_name' => 'Vovich',
			'third_name' => 'Vovin',
			'position' => 'Boss',
			'agreement' => 'B2',
			'contract_number' => '243324',
			'contract_date' => '2001-02-16',
			'resident' => 'true',
			'commission_business' => '132.00',
			'commission_first' => '132.00',
			'commission_economy' => '132.00',
			'status' => 'true',
			'limit' => 'true',
			'residue_limit' => '132.00',
			'invoice_payment' => 'true',
			'fees_avia' => 'true',
			'support_contacts' => 'для звонков с мобильных телефонов',
			'manager_id' => '1'
        ]);

    }
}
