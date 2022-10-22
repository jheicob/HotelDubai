<?php

namespace Tests\Feature;

use App\Services\FiscalInvoice\FiscalInvoiceService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FiscalInvoiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function instanceService(){
        $service = new FiscalInvoiceService();

        $service->addLineToHead('algo');

        $this->assertEquals('69|00|Hotel Dubai - 123456\n69|01|algo\n',$service->download('algo'));
    }
}
