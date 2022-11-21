<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reception_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            $table->foreignId('extra_guest_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            $table->foreignId('client_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
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
        Schema::dropIfExists('companions');
    }
}
