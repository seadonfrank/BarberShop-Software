<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email_address')->unique();
            $table->string('phone_number');
            $table->boolean('is_student');
            $table->boolean('is_child');
            $table->boolean('is_military');
            $table->boolean('is_beard');
            $table->boolean('send_reminders');
            $table->dateTime('next_reminder');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('customers');
    }
}
