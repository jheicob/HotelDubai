<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartialCostToRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // drop foreign id and fields
        Schema::table('rooms', function (Blueprint $table) {

            $table->dropColumn([
                'partial_rate_id',
                'room_type_id',
            ]);
        });

        // add field for relationship for table partial_costs
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('partial_cost_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            //
        });
    }
}
