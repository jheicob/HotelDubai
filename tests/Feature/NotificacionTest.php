<?php

namespace Tests\Feature;

use App\Events\CrateNotificationEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificacionTest extends TestCase
{
    /**
     * @test
     */
    public function a_notificacion_can_be_created()
    {
        
        event(new CrateNotificationEvent('0001','Disponible'));
    }
}
