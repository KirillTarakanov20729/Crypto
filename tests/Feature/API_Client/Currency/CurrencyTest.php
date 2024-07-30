<?php

namespace Tests\Feature\API_Client\Currency;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_currency_index_work(): void
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

        $response = $this->post('api/client/currencies/index', [
            'page' => 1
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('USD');
    }

    public function test_currency_show_work(): void
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

        $response = $this->get('api/client/currencies/show/1', [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('USD');
    }

    public function test_currency_delete_work(): void
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

        $response = $this->delete('api/client/currencies/delete/1', [],
            [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('currencies', [
            'id' => 1
        ]);
    }

    public function test_currency_store_work(): void
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

        $response = $this->post('api/client/currencies/store', [
            'name' => 'Bitcoin',
            'symbol' => 'BTC'
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('currencies', [
            'name' => 'Bitcoin',
            'symbol' => 'BTC'
        ]);
    }

    public function test_currency_update_work(): void
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

        $response = $this->put('api/client/currencies/update', [
            'id' => 1,
            'name' => 'Bitcoin',
            'symbol' => 'BTC'
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('currencies', [
            'name' => 'Bitcoin',
            'symbol' => 'BTC'
        ]);
    }
}
