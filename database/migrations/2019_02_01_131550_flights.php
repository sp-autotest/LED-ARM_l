<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Flights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('count_places')->nullable();
            $table->integer('created_id');
            $table->integer('updated_id');
            $table->integer('flights_places_id');
            $table->integer('count_places_reservation')->nullable();
            $table->date('date_departure_at')->nullable();
            $table->decimal('ow', 12, 2)->nullable();
            $table->decimal('rt', 12, 2)->nullable();
            $table->decimal('infant_ow', 12, 2)->nullable();
            $table->decimal('infant_rt', 12, 2)->nullable();
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
        Schema::dropIfExists('flights');
    }
}
