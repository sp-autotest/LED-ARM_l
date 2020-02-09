<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Services extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('service_id');
            $table->integer('departure_at');
            $table->integer('arrival_at');
            $table->integer('type_flight');
            $table->timestamp('departure_date');
            $table->timestamp('arrival_date')->nullable();
            $table->integer('service_status')->nullable();
            $table->integer('user_id');
            $table->decimal('summary_summ', 12, 2);
            $table->integer('passenger_id');
            $table->string('pnr');
            $table->integer('provider_id');
            $table->integer('segment_number');
            $table->integer('schedule_id');
            $table->integer('fare_families_id');
            $table->integer('airlines_id');
            $table->string('baggage_allowance')->nullable();
            $table->integer('type_bc_id')->nullable();
            $table->integer('created_id');
            $table->integer('updated_id');
            $table->timestamps();
            $table->integer('tickets_id')->nullable();
            $table->string('fare_families_crane')->nullable();
            $table->dateTime('booking_date');
            $table->dateTime('discharge_date');
            $table->string('schedule_crane');
            $table->string('referense_id');
            $table->integer('flight_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('services');
    }
}
