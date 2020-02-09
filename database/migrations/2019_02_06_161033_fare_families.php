<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FareFamilies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fare_families', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10);
            $table->string('name_eng');
            $table->string('name_ru');
            $table->integer('luggage_adults');
            $table->integer('luggage_children');
            $table->integer('luggage_infants');
            $table->integer('max_stay');
            $table->integer('fare_families_group')->default(1);
            $table->text('note_fare');
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
        Schema::dropIfExists('fare_families');
    }
}
