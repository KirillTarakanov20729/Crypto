<?php

namespace Tests\Feature\API_Client\Coin;

use App\Models\User;
use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoinTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_coin_index_work(): void
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

        $response = $this->post('api/client/coins/index', [
            'page' => 1
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('BTC');
    }

    public function test_coin_store_work(): void
    {
        $user = $this->create_admin_user();

        $this->actingAs($user, 'api');

        $response = $this->post('api/client/auth/login', [
            'email' => $user->email,
            'password' => 'admin1234',
        ]);

        $accessToken = $response->json('access_token');

        $response->assertStatus(200);

        $response = $this->post('api/client/coins/store', [
            'name' => 'Bitcoin',
            'symbol' => 'BTC',
            'price' => 40000
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('coins', [
            'name' => 'Bitcoin',
            'symbol' => 'BTC',
            'price' => 40000
        ]);
    }

    public function test_coin_update_work(): void
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

        $response = $this->put('api/client/coins/update', [
            'id' => 1,
            'name' => 'Bitcoin New',
            'symbol' => 'BTC',
            'price' => 40000
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('coins', [
            'name' => 'Bitcoin New',
            'symbol' => 'BTC',
            'price' => 40000
        ]);
    }

    public function test_coin_delete_work(): void
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

        $response = $this->delete('api/client/coins/delete', [
            'id' => 1
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('coins', [
            'id' => 1
        ]);
    }

    public function test_coin_show_work(): void
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

        $response = $this->get('api/client/coins/show/1', [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('BTC');
    }
}
