<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	Role::create(['name' => 'admin', 'guard_name' => 'api']);
    	
DB::table('permissions')->insert([
'name' => 'desktop.see-cancellation-requests',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'desktop.write-message',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'search.index',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'search-avia.index',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'search-avia.booking',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'orders.index',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'orders.see-all-orders',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'orders.see-your-orders',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'orders.enter-order',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'orders.open-order',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'orders.close-order',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'orders.service-processing',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);


DB::table('permissions')->insert([
'name' => 'services.cancellation',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'services.block-service',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);

DB::table('permissions')->insert([
'name' => 'services.ticket-issuance',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'services.unloading-mk',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);

DB::table('permissions')->insert([
'name' => 'services.refund-request',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);

DB::table('permissions')->insert([
'name' => 'messages.index',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'messages.posting',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);

DB::table('permissions')->insert([
'name' => 'reports.index',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'reports.create-report',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'reports.to-excel',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'reports.to-email',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.index',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.company-create',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.company-list',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);

DB::table('permissions')->insert([
'name' => 'administration.access-to-quotes',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.settings',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.fees-settings',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.commission-settings',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.create-user',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.users-permissions',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.password-resets',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.mailing-setup',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.groups',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.history',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'administration.dictionaries',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'finance.index',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'finance.invoicing',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'finance.list-invoice',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
DB::table('permissions')->insert([
'name' => 'finance.refill-invoice',
'guard_name' => 'api',
'created_at' => '2001-02-16 20:38:40',
'updated_at' => '2001-02-16 20:38:40'
]);
    }
}
