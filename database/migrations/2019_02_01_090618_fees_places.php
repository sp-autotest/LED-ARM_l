<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeesPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_places', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_stop')->nullable();
            $table->timestamp('period_begin_at')->nullable();
            $table->timestamp('period_end_at')->nullable();
            $table->integer('airlines_id')->nullable();
            $table->integer('departure_city')->nullable();
            $table->integer('arrival_city')->nullable();
            $table->integer('type_action');
            $table->boolean('non_return')->default(true);
            $table->integer('fare_families_id')->nullable();
            $table->integer('type_flight');
            $table->boolean('infant')->default(true);
            $table->integer('country_id_departure')->nullable();
            $table->integer('country_id_arrival')->nullable();
            $table->integer('type_fees_inscribed')->nullable();
            $table->integer('type_fees_charge')->nullable();
            $table->integer('size_fees_inscribed')->nullable();
            $table->integer('size_fees_charge')->nullable();
            $table->integer('size_fees_exchange')->nullable();
            $table->integer('max_fees_inscribed')->nullable();
            $table->integer('max_fees_charge')->nullable();
            $table->integer('max_fees_exchange')->nullable();
            $table->integer('min_fees_inscribed')->nullable();
            $table->integer('min_fees_charge')->nullable();
            $table->integer('min_fees_exchange')->nullable();
            $table->integer('type_deviation')->nullable();
            $table->integer('size_deviation')->nullable();
            $table->integer('created_id');
            $table->integer('company_id');
            $table->integer('types_fees_id');
            $table->integer('type_fees_exchange');
            $table->integer('fare_families_group');
            $table->integer('updated_id');
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
        Schema::table('fees_places', function (Blueprint $table) {
            //
        });
    }
}
