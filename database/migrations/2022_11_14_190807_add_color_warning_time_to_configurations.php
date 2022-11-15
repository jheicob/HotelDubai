<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorWarningTimeToConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('color_warning_time')->default('');
            $table->string('color_past_time')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('color_warning_time');
        });
    }
}
