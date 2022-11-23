<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHoursToDayTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_templates', function (Blueprint $table) {
            $table->string('hour_start')->nullable();
            $table->string('hour_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_templates', function (Blueprint $table) {
            $table->dropColumn([
                'hour_start',
                'hour_end'
            ]);
        });
    }
}
