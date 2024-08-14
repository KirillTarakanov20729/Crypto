<?php

namespace Tests\Feature\API_Client\Payment;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_index_payment_work()
    {
        $user = $this->create_admin_user();

        $this->create_data();

        $this->actingAs($user, 'api');

        $response = $this->post('api/client/auth/login', [
            'email' => $user->email,
            'password' => 'admin1234',
        ]);

        $accessToken = $response->json('access_token');

        $response->assertStatus(200);

        $response = $this->post('api/client/payments/index', [
            'page' => 1], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_payment_work()
    {
        $user = $this->create_admin_user();

        $this->create_data();

        $this->actingAs($user, 'api');

        $response = $this->post('api/client/auth/login', [
            'email' => $user->email,
            'password' => 'admin1234',
        ]);

        $accessToken = $response->json('access_token');

        $response->assertStatus(200);

        $response = $this->delete('api/client/payments/delete/1', [], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);
    }
}
