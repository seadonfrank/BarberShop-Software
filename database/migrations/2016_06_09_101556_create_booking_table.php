<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('user_id');
            $table->enum('status', ['Processed', 'Finalised', 'Canceled']);
            $table->boolean('send_reminders');
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
        Schema::drop('bookings');
    }
}
