<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('amount', 8, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
