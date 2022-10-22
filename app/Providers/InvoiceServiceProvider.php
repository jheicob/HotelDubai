<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Services\FiscalInvoice\CreditNoteService;
use App\Services\FiscalInvoice\DebitNoteService;
use App\Services\Invoice\InvoiceService;
use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InvoiceService::class, function () {
            return new InvoiceService(new Invoice(),new CreditNoteService, new DebitNoteService);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
