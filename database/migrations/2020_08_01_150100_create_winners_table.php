<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sender_number','11');
            $table->timestamp('created_at');
            $table->unsignedBigInteger('voucher_id');
            $table->foreign('code_id')->references('id')->on('codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('winners');

    }
}
