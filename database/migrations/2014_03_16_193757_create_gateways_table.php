<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider_name', 50);
            $table->string('provider_url');
            $table->boolean('is_on_site');
            $table->boolean('can_refund')->default(0);
            $table->string('name', 50);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payment_gateways');
    }
}
