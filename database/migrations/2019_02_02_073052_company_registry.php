<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyRegistry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('companies')) {
         Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name', 255);
            $table->string('legal_company_name', 255)->nullable();
            $table->text('post_address')->nullable();
            $table->text('legal_address');
            $table->string('city', 150);
            $table->string('phone', 150);
            $table->string('finance_mail', 150);
            $table->string('report_mail', 150);
            $table->string('logo', 255)->nullable();
            $table->string('fax', 150)->nullable();
            $table->integer('currency_id');
            $table->integer('parent')->nullable();
            $table->string('okud', 150)->nullable();
            $table->string('inn', 150)->nullable();
            $table->string('okonh', 150)->nullable();
            $table->string('kpp', 150)->nullable();
            $table->string('ogrn', 150)->nullable();
            $table->string('bank_name', 255);
            $table->string('сhecking_account', 150);
            $table->string('bik', 150);
            $table->string('correspondent_account', 150);
            $table->string('first_name', 150);
            $table->string('second_name', 150);
            $table->string('third_name', 150);
            $table->string('position', 150)->nullable();
            $table->string('agreement', 255)->nullable();
            $table->string('contract_number', 150);
            $table->date('contract_date');
            $table->boolean('resident')->default(false);
            $table->decimal('commission_business', 12, 2)->nullable();
            $table->decimal('commission_first', 12, 2)->nullable();
            $table->decimal('commission_economy', 12, 2)->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('limit')->default(true);
            $table->decimal('residue_limit', 12, 4);
            $table->boolean('invoice_payment')->default(true);
            $table->boolean('fees_avia')->default(true);
            $table->text('support_contacts')->nullable();
            $table->integer('created_id');
            $table->integer('updated_id');
            $table->integer('countnumber')->nullable();
            $table->integer('manager_id');
            $table->timestamps();
        });
         }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies');
    }
}

