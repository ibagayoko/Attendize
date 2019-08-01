<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateEventImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_images', function ($t) {
            $t->increments('id');
            $t->string('image_path');
            $t->nullableTimestamps();

            $t->unsignedInteger('event_id');
            $t->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $t->unsignedInteger('account_id');
            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $t->unsignedInteger('user_id');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_images');
    }
}
