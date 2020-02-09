<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('additional_phone')->nullable();
            $table->string('additional_email')->nullable();
            $table->boolean('sex')->nullable();
            $table->string('position')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
