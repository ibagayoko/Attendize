<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            /*
         * Accounts table
         */
        Schema::create('accounts', function ($t) {
            $t->increments('id');

            $t->string('first_name');
            $t->string('last_name');
            $t->string('email');

            $t->unsignedInteger('timezone_id')->nullable();
            $t->unsignedInteger('date_format_id')->nullable();
            $t->unsignedInteger('datetime_format_id')->nullable();
            $t->unsignedInteger('currency_id')->nullable();
            $t->unsignedInteger('payment_gateway_id')->default(config('attendize.payment_gateway_stripe'));
            $t->nullableTimestamps();
            $t->softDeletes();

            $t->string('name')->nullable();
            $t->string('last_ip')->nullable();
            $t->timestamp('last_login_date')->nullable();

            $t->string('address1')->nullable();
            $t->string('address2')->nullable();
            $t->string('city')->nullable();
            $t->string('state')->nullable();
            $t->string('postal_code')->nullable();
            $t->unsignedInteger('country_id')->nullable();
            $t->text('email_footer')->nullable();

            $t->boolean('is_active')->default(false);
            $t->boolean('is_banned')->default(false);
            $t->boolean('is_beta')->default(false);

            $t->string('stripe_access_token', 55)->nullable();
            $t->string('stripe_refresh_token', 55)->nullable();
            $t->string('stripe_secret_key', 55)->nullable();
            $t->string('stripe_publishable_key', 55)->nullable();
            $t->text('stripe_data_raw', 55)->nullable();

            $t->foreign('timezone_id')->references('id')->on('timezones');
            $t->foreign('date_format_id')->references('id')->on('date_formats');
            $t->foreign('datetime_format_id')->references('id')->on('date_formats');
            $t->foreign('payment_gateway_id')->references('id')->on('payment_gateways');
            $t->foreign('currency_id')->references('id')->on('currencies');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
