<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThermostatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thermostats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('state');
            $table->unsignedDecimal('target_temperature', 3, 1);
            $table->unsignedDecimal('target_humidity', 3, 2);
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
        Schema::dropIfExists('thermostats');
    }
}
