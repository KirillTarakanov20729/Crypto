<?php

namespace Tests\Feature\API_Telegram\Payment;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;
    public function test_payment_show_work(): void
    {
        $this->create_data();

        $payment = $this->get_one_payment();

        $response = $this->post('api/telegram/payments/show', [
            'uuid' => $payment->uuid,
        ]);

        $response->assertStatus(200);
    }
}
