<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('currencies', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('title', 255);
            $table->string('symbol_left', 12);
            $table->string('symbol_right', 12);
            $table->string('code', 3);
            $table->integer('decimal_place');
            $table->double('value', 15, 8);
            $table->string('decimal_point', 3);
            $table->string('thousand_point', 3);
            $table->integer('status');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
