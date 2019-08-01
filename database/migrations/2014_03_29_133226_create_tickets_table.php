<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Tickets table
         */
        Schema::create('tickets', function ($t) {
            $t->increments('id');
            $t->nullableTimestamps();
            $t->softDeletes();

            $t->unsignedInteger('edited_by_user_id')->nullable();
            $t->unsignedInteger('account_id')->index();
            $t->unsignedInteger('order_id')->nullable();

            $t->unsignedInteger('event_id')->index();
            $t->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $t->string('title');
            $t->text('description');
            $t->decimal('price', 13, 2);
            $t->integer('sort_order')->default(0);

            $t->integer('max_per_person')->nullable()->default(null);
            $t->integer('min_per_person')->nullable()->default(null);

            $t->integer('quantity_available')->nullable()->default(null);
            $t->integer('quantity_sold')->default(0);

            $t->dateTime('start_sale_date')->nullable();
            $t->dateTime('end_sale_date')->nullable();

            $t->decimal('sales_volume', 13, 2)->default(0);
            $t->decimal('organiser_fees_volume', 13, 2)->default(0);

            $t->tinyInteger('is_paused')->default(0);
            $t->boolean('is_hidden')->default(0);

            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $t->foreign('order_id')->references('id')->on('orders');
            $t->foreign('edited_by_user_id')->references('id')->on('users');

            $t->unsignedInteger('public_id')->nullable()->index();

            $t->unsignedInteger('user_id');
            $t->foreign('user_id')->references('id')->on('users');
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
