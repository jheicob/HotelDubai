<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartialCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'partial_costs', function (Blueprint $table) {
                $table->id();

                $table->foreignId('room_type_id');
                $table->foreignId('partial_rates_id');
                $table->decimal('rate', 10, 2);

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('room_type_id')
                    ->on('room_types')
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
        Schema::dropIfExists('partial_costs');
    }
}
