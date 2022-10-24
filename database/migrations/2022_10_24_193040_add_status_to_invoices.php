<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('status', [
                'Impreso',
                'Sin Imprimir',
                'Error Imprimiendo',
                'Cancelada'
            ])
                ->default('Sin Imprimir')
                ->comment('Estado de la factura: Impreso,Sin Imprimir,Error Imprimiendo,Cancelada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
