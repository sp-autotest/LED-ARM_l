<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('providers_id');
            $table->integer('ordering_a');
            $table->string('ordering_p', 255);
            $table->text('adding');
            $table->integer('created_id');
            $table->integer('updated_id');
            $table->string('login_a');
            $table->string('login_b');
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
        Schema::dropIfExists('a_providers');
    }
}
