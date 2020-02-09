<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');;
            $table->integer('order_n');
            $table->integer('status');
            $table->integer('type_order');
            $table->integer('company_registry_id');
            $table->integer('user_id');
            $table->decimal('order_summary', 20, 2); //в спецификации стоит NUMERIC, но логически вернее ставить decimal
            $table->integer('order_currency');
            $table->integer('passengers');
            $table->integer('services');
            $table->integer('time_limit');
            $table->integer('type_payment');
            $table->string('email');
            $table->string('phone');
            $table->text('comment')->nullable();
            $table->integer('created_id');
            $table->integer('conversation_id');
            $table->boolean('gds_ticket');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
