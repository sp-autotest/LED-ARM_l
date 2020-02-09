<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Schedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('departure_at')->nullable();
            $table->integer('arrival_at')->nullable();
            $table->boolean('is_transplantation')->default(false);
            $table->boolean('monday')->default(false);
            $table->boolean('tuesday')->default(false);
            $table->boolean('wednesday')->default(false);
            $table->boolean('thursday')->default(false);
            $table->boolean('friday')->default(false);
            $table->boolean('saturday')->default(false);
            $table->boolean('sunday')->default(false);
            $table->integer('airlines_id')->nullable();
            $table->integer('created_id');
            $table->integer('updated_id');
            $table->timestamps();
            $table->dateTime('period_begin_at')->nullable();
            $table->dateTime('period_end_at')->nullable();
            $table->string('flights')->nullable();
            $table->integer('leg')->nullable();
            $table->integer('bc_types_id')->nullable();
            $table->time('time_departure_at')->nullable();
            $table->time('time_arrival_at')->nullable();
            $table->boolean('next_day')->default(false);
            $table->dateTime('time_arrival_transfer_at')->nullable();
            $table->integer('flight_places_id')->nullable();
            $table->integer('schedule_id')->nullable();
            $table->time('flight_duration')->nullable();






        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule');
    }
}
