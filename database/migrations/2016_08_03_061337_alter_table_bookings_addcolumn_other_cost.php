<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBookingsAddcolumnOtherCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bookings', function(Blueprint $table)
        {
            $table->decimal('other_cost');
            $table->string('other_service');
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
        Schema::table('bookings', function(Blueprint $table)
        {
            $table->dropColumn('other_cost');
            $table->dropColumn('other_service');
        });
    }
}
