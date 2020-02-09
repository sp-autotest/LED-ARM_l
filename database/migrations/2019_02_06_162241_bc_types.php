<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BcTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_eng');
            $table->string('name_ru');
            $table->string('aircraft_class_code');
            $table->string('ccp');
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
        Schema::dropIfExists('bc_types');
    }
}
