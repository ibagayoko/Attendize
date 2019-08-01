<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisers', function ($table) {
            $table->increments('id')->index();

            $table->nullableTimestamps();
            $table->softDeletes();

            $table->unsignedInteger('account_id')->index();

            $table->string('name');
            $table->text('about');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('confirmation_key', 20);
            $table->string('facebook');
            $table->string('twitter');
            $table->string('logo_path')->nullable();
            $table->boolean('is_email_confirmed')->default(false);
            $table->string('google_analytics_code')->nullable();
            $table->string('google_tag_manager_code', 20)->nullable();
            $table->boolean('enable_organiser_page')->default(true);

            $table->boolean('show_twitter_widget')->default(false);
            $table->boolean('show_facebook_widget')->default(false);

            $table->string('page_header_bg_color', 20)->default('#76a867');
            $table->string('page_bg_color', 20)->default('#EEEEEE');
            $table->string('page_text_color', 20)->default('#FFFFFF');
            $table->boolean('charge_tax')->default(0);
            $table->string('tax_name', 15)->nullable();
            $table->float('tax_value')->nullable();
            $table->string('tax_id', 100)->nullable();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisers');
    }
}
