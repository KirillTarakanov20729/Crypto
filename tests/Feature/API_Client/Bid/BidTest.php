<?php

namespace Tests\Feature\API_Client\Bid;

use App\Enums\API_Client\Bid\BidPaymentMethodEnum;
use App\Enums\API_Client\Bid\BidTypeEnum;
use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BidTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_bid_index_work(): void
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

        $response = $this->post('api/client/bids/index', [
            'page' => 1,
            'per_page' => 10
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('price');
    }

    public function test_bid_show_work(): void
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

        $response = $this->get('api/client/bids/show/1', [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('40000');
    }

    public function test_bid_delete_work(): void
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

        $response = $this->delete('api/client/bids/delete/1', [], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('bids', [
            'id' => 1
        ]);
    }

    public function test_bid_store_work(): void
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

        $response = $this->post('api/client/bids/store', [
            'user_telegram_id' => "232323",
            'coin_id' => 1,
            'currency_id' => 1,
            'price' => 50000,
            'amount' => 40000,
            'type' => 'sell',
            'number' => '+7 999 999 99 99',
            'payment_method' => 'Alfa-bank',
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('bids', [
            'user_id' => 1,
            'coin_id' => 1,
            'currency_id' => 1,
            'price' => 50000,
            'amount' => 40000
        ]);
    }

    public function test_bid_update_work(): void
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

        $response = $this->put('api/client/bids/update', [
            'id' => 1,
            'user_telegram_id' => "232323",
            'coin_id' => 1,
            'currency_id' => 1,
            'price' => 50000,
            'amount' => 40000,
            'status' => 'created',
            'type' => 'sell',
            'number' => '+7 999 999 99 99',
            'payment_method' => 'Alfa-bank',
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('bids', [
            'id' => 1,
            'price' => 50000
        ]);
    }
}
