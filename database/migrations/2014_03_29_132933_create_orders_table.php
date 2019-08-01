<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Users table
         */
        Schema::create('orders', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('account_id')->index();
            $t->unsignedInteger('order_status_id');
            $t->nullableTimestamps();
            $t->softDeletes();

            $t->string('first_name');
            $t->string('last_name');
            $t->string('email');
            $t->string('business_name')->nullable();
            $t->string('business_tax_number')->nullable();
            $t->string('business_address_line_one')->nullable();
            $t->string('business_address_line_two')->nullable();
            $t->string('business_address_state_province')->nullable();
            $t->string('business_address_city')->nullable();
            $t->string('business_address_code')->nullable();
            $t->string('ticket_pdf_path', 155)->nullable();

            $t->string('order_reference', 15);
            $t->string('transaction_id', 50)->nullable();

            $t->decimal('discount', 8, 2)->nullable();
            $t->decimal('booking_fee', 8, 2)->nullable();
            $t->decimal('organiser_booking_fee', 8, 2)->nullable();
            $t->date('order_date')->nullable();

            $t->text('notes')->nullable();
            $t->boolean('is_deleted')->default(0);
            $t->boolean('is_cancelled')->default(0);
            $t->boolean('is_partially_refunded')->default(0);
            $t->boolean('is_refunded')->default(0);
            $t->boolean('is_payment_received')->default(0);
            $t->boolean('is_business')->default(false);

            $t->decimal('amount', 13, 2);
            $t->decimal('amount_refunded', 13, 2)->nullable();
            $t->float('taxamt')->nullable();

            $t->unsignedInteger('event_id')->index();
            $t->unsignedInteger('payment_gateway_id')->nullable();

            $t->foreign('payment_gateway_id')->references('id')->on('payment_gateways');
            $t->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $t->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
