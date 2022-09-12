<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartialTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'partial_templates', function (Blueprint $table) {
                $table->id();

                $table->foreignId('room_type_id');
                $table->foreignId('day_week_id');
                $table->foreignId('system_time_id');
                $table->foreignId('shift_system_id');
                $table->foreignId('partial_rates_id');

                $table->softDeletes();
                $table->timestamps();

                $table->foreign('room_type_id')
                    ->on('room_types')
                    ->references('id')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('day_week_id')
                    ->on('day_weeks')
                    ->references('id')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('system_time_id')
                    ->on('system_times')
                    ->references('id')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('shift_system_id')
                    ->on('shift_systems')
                    ->references('id')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('partial_rates_id')
                    ->on('partial_rates')
                    ->references('id')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partial_templates');
    }
}
