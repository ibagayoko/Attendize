<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function ($table) {
            $table->increments('id');
            $table->text('message');
            $table->string('subject');
            $table->integer('recipients')->nullable(); //ticket_id or null for all
            $table->unsignedInteger('account_id')->index();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('is_sent')->default(0);
            $table->dateTime('sent_at')->nullable();
            $table->nullableTimestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
