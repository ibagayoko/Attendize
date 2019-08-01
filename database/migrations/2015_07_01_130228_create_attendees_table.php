<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('order_id')->index();
            $t->unsignedInteger('event_id')->index();
            $t->unsignedInteger('ticket_id')->index();

            $t->string('first_name');
            $t->string('last_name');
            $t->string('email');

            $t->integer('reference_index')->default(0);
            $t->string('private_reference_number', 15)->index();

            $t->nullableTimestamps();
            $t->softDeletes();

            $t->boolean('is_cancelled')->default(false);
            $t->boolean('is_refunded')->default(false);
            $t->boolean('has_arrived')->default(false);
            $t->dateTime('arrival_time')->nullable();

            $t->unsignedInteger('account_id')->index();
            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $t->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $t->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $t->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendees');
    }
}
