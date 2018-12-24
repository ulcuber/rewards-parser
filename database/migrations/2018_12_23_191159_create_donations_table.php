<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reward_id')->unsigned()->nullable();
            $table->foreign('reward_id')->references('id')->on('rewards')->onDelete('cascade');

            $table->decimal('amount', 8, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
