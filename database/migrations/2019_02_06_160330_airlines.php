<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Airlines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airlines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code_tkp', 10);
            $table->string('aviacompany_name_ru', 255);
            $table->string('short_aviacompany_name_ru', 100);
            $table->string('aviacompany_name_eng', 255);
            $table->string('short_aviacompany_name_eng', 100);
            $table->string('code_iata', 10);
            $table->string('account_code_iata', 10);
            $table->integer('account_code_tkp');
            $table->integer('city_id');
            $table->timestamp('date_begin_at');
            $table->timestamp('date_end_at');
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
        Schema::dropIfExists('airlines');
    }
}
