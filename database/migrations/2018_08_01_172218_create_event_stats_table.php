<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateEventStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_stats', function ($table) {
            $table->increments('id')->index();
            $table->date('date');
            $table->integer('views')->default(0);
            $table->integer('unique_views')->default(0);
            $table->integer('tickets_sold')->default(0);

            $table->decimal('sales_volume', 13, 2)->default(0);
            $table->decimal('organiser_fees_volume', 13, 2)->default(0);

            $table->unsignedInteger('event_id')->index();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_stats');
    }
}
