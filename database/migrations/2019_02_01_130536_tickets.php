<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_number')->nullable();
            $table->decimal('rate_fare', 12, 2)->nullable();
            $table->decimal('commission_fare', 12, 2)->nullable();
            $table->decimal('types_fees_fare', 12, 2)->nullable();
            $table->decimal('fine_exchange', 12, 2)->nullable();
            $table->datetime('writeout_date')->nullable();
            $table->decimal('tax_fare', 12, 2)->nullable();
            $table->integer('types_fees_id')->nullable();
            $table->decimal('summ_ticket', 12, 2)->nullable();
            $table->integer('passengers_id')->nullable();
            $table->integer('created_id');
            $table->integer('updated_id');
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
        Schema::dropIfExists('tickets');
    }
}
