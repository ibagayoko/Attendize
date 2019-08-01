<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateTicketOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Tickets / Orders pivot table
         */
        Schema::create('ticket_order', function ($t) {
            $t->increments('id');
            $t->integer('order_id')->unsigned()->index();
            $t->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $t->integer('ticket_id')->unsigned()->index();
            $t->foreign('ticket_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_order');
    }
}
