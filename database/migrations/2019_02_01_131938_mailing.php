<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mailing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(false);
            $table->integer('type_mailing')->nullable();
            $table->integer('mail_list')->nullable();
            $table->integer('created_id');
            $table->integer('updated_id');
            $table->integer('company_registry_id');
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
        Schema::dropIfExists('mailing');
    }
}
