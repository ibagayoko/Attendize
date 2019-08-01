<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*
         * Users Table
         */
        Schema::create('users', function ($t) {
            $t->increments('id');
            $t->unsignedInteger('account_id')->index();
            $t->nullableTimestamps();
            $t->softDeletes();

            $t->string('first_name')->nullable();
            $t->string('last_name')->nullable();
            $t->string('phone')->nullable();
            $t->string('email');
            $t->string('password');
            $t->string('confirmation_code');
            $t->boolean('is_registered')->default(false);
            $t->boolean('is_confirmed')->default(false);
            $t->boolean('is_parent')->default(false);
            $t->string('remember_token', 100)->nullable();
            $t->string('api_token', 60)->unique()->nullable();

            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });

        /*
         * checkbox, multiselect, select, radio, text etc.
         */
//        Schema::create('question_types', function($t) {
//            $t->increments('id');
//            $t->string('name');
//            $t->boolean('allow_multiple')->default(FALSE);
//        });
//
//
//        Schema::create('questions', function($t) {
//            $t->nullableTimestamps();
//            $t->softDeletes();
//
//            $t->increments('id');
//
//            $t->string('title', 255);
//            $t->text('instructions');
//            $t->text('options');
//
//
//            $t->unsignedInteger('question_type_id');
//            $t->unsignedInteger('account_id')->index();
//
//            $t->tinyInteger('is_required')->default(0);
//
//
//            /*
//             * If multi select - have question options
//             */
//            $t->foreign('question_type_id')->references('id')->on('question_types');
//            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');$t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
//
//        });
//
//        /**
//         * Related to each question  , can have one or many
//         * Whats you name etc?
//         *
//         */
//        Schema::create('question_options', function($t) {
//            $t->increments('id');
//            $t->string('name');
//            $t->integer('question_id')->unsigned()->index();
//            $t->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
//        });
//
//
//        Schema::create('answers', function($t) {
//            $t->increments('id');
//
//
//            $t->integer('question_id')->unsigned()->index();
//            $t->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
//
//            $t->integer('ticket_id')->unsigned()->index();
//            $t->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
//
//            $t->text('answer');
//        });
//
//
//
//
//        /**
//         * Tickets / Questions pivot table
//         */
//        Schema::create('event_question', function($t) {
//            $t->increments('id');
//            $t->integer('event_id')->unsigned()->index();
//            $t->foreign('event_id')->references('id')->on('event')->onDelete('cascade');
//            $t->integer('question_id')->unsigned()->index();
//            $t->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
//        });
//

        /*
         * Tickets / Questions pivot table
         */
//        Schema::create('ticket_question', function($t) {
//            $t->increments('id');
//            $t->integer('ticket_id')->unsigned()->index();
//            $t->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
//            $t->integer('question_id')->unsigned()->index();
//            $t->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'users',
            'tickets',
            'order_items',
            'event_stats',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            Schema::drop($table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
