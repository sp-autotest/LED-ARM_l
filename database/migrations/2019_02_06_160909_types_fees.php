<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TypesFees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_eng');
            $table->string('name_ru');
            $table->date('date_of_start');
            $table->date('date_of_stop');
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
        Schema::dropIfExists('types_fees');
    }
}
