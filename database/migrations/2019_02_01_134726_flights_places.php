<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FlightsPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights_places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('count_places')->nullable();
            $table->decimal('ow', 12, 2)->nullable();
            $table->decimal('infant_ow', 12, 2)->nullable();
            $table->decimal('rt', 12, 2)->nullable();
            $table->decimal('infant_rt', 12, 2)->nullable();
            $table->integer('created_id');
            $table->integer('updated_id');
            $table->integer('currency_id');
            $table->integer('fare_families_id');
            $table->boolean('infant')->default(false);
            $table->date('period_begin_at');
            $table->date('period_end_at');
            $table->boolean('flight_generated')->default(false);
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
        Schema::dropIfExists('flights_places');
    }
}
