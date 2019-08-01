<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function ($t) {
            $t->increments('id');
            $t->string('name');
        });

        Schema::create('ticket_statuses', function ($table) {
            $table->increments('id');
            $table->text('name');
        });

        Schema::create('reserved_tickets', function ($table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->integer('event_id');
            $table->integer('quantity_reserved');
            $table->datetime('expires');
            $table->string('session_id', 45);
            $table->nullableTimestamps();
        });

        Schema::create('timezones', function ($t) {
            $t->increments('id');
            $t->string('name');
            $t->string('location');
        });

        Schema::create('date_formats', function ($t) {
            $t->increments('id');
            $t->string('format');
            $t->string('picker_format');
            $t->string('label');
        });

        Schema::create('datetime_formats', function ($t) {
            $t->increments('id');
            $t->string('format');
            $t->string('picker_format');
            $t->string('label');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'order_statuses',
            'ticket_statuses',
            'reserved_tickets',
            'timezones',
            'date_formats',
            'datetime_formats',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            Schema::drop($table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
