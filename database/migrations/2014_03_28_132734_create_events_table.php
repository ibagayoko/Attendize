<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function ($t) {
            $t->increments('id');

            $t->string('title');
            $t->string('location')->nullable();
            $t->string('bg_type', 15)->default('color');
            $t->string('bg_color')->default(config('attendize.event_default_bg_color'));
            $t->string('bg_image_path')->nullable();
            $t->text('description');
            $t->boolean('is_1d_barcode_enabled')->default(0);
            $t->dateTime('start_date')->nullable();
            $t->dateTime('end_date')->nullable();

            $t->dateTime('on_sale_date')->nullable();

            $t->integer('account_id')->unsigned()->index();
            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $t->integer('user_id')->unsigned();
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $t->unsignedInteger('currency_id')->nullable();
            $t->foreign('currency_id')->references('id')->on('currencies');

            $t->decimal('sales_volume', 13, 2)->default(0);
            $t->decimal('organiser_fees_volume', 13, 2)->default(0);
            $t->decimal('organiser_fee_fixed', 13, 2)->default(0);
            $t->decimal('organiser_fee_percentage', 4, 3)->default(0);
            $t->unsignedInteger('organiser_id');
            $t->foreign('organiser_id')->references('id')->on('organisers');
            $t->string('event_image_position')->nullable();

            $t->string('venue_name');
            $t->string('venue_name_full')->nullable();
            $t->string('location_address', 355)->nullable();
            $t->string('location_address_line_1', 355);
            $t->string('location_address_line_2', 355);
            $t->string('location_country')->nullable();
            $t->string('location_country_code')->nullable();
            $t->string('location_state');
            $t->string('location_post_code');
            $t->string('location_street_number')->nullable();
            $t->string('location_lat')->nullable();
            $t->string('location_long')->nullable();
            $t->string('location_google_place_id')->nullable();

            $t->text('pre_order_display_message')->nullable();

            $t->text('post_order_display_message')->nullable();

            $t->boolean('enable_offline_payments')->default(0);
            $t->text('offline_payment_instructions')->nullable();

            $t->text('social_share_text')->nullable();
            $t->boolean('social_show_facebook')->default(true);
            $t->boolean('social_show_linkedin')->default(true);
            $t->boolean('social_show_twitter')->default(true);
            $t->boolean('social_show_email')->default(true);
            $t->boolean('social_show_googleplus')->default(true);
            $t->boolean('social_show_whatsapp')->default(true);

            $t->unsignedInteger('location_is_manual')->default(0);

            $t->boolean('is_live')->default(false);
            /*
             * @see https://github.com/milon/barcode
             *  AddTicketDesignOptions
             */
            $t->string('barcode_type', 20)->default('QRCODE');
            $t->string('ticket_border_color', 20)->default('#000000');
            $t->string('ticket_bg_color', 20)->default('#FFFFFF');
            $t->string('ticket_text_color', 20)->default('#000000');
            $t->string('ticket_sub_text_color', 20)->default('#999999');
            $t->string('google_tag_manager_code', 20)->nullable();

            $t->string('questions_collection_type', 10)->default('buyer'); // buyer or attendee
            $t->integer('checkout_timeout_after')->default(8); // timeout in mins for checkout

            $t->nullableTimestamps();
            $t->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
