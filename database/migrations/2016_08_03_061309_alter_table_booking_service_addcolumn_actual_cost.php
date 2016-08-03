<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBookingServiceAddcolumnActualCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('booking_service', function(Blueprint $table)
        {
            $table->boolean('actual_cost');
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
        Schema::table('booking_service', function(Blueprint $table)
        {
            $table->dropColumn('actual_cost');
        });
    }
}
