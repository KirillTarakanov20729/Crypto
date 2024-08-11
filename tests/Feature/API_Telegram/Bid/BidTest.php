<?php

namespace Tests\Feature\API_Telegram\Bid;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BidTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_bid_index_work()
    {
        $this->create_data();

        $response = $this->post('api/telegram/bids/index', [
            'page' => 1,
            'user_telegram_id' => '232323',
        ]);

        $response->assertStatus(200);

        $response->assertSee('price');
    }

    public function test_bid_store_work()
    {
        $this->create_data();

        $response = $this->post('api/telegram/bids/store', [
            'price' => 100,
            'user_telegram_id' => '232323',
            'coin_symbol' => 'BTC',
            'currency_symbol' => 'USD',
            'amount' => 100,
            'type' => 'buy',
            'payment_method' => 'Sber',
            'number' => "+79999999999",
        ]);

        $response->assertStatus(201);
    }

    public function test_user_bids_index_work()
    {
        $this->create_data();

        $response = $this->post('api/telegram/bids/index', [
            'page' => 1,
            'user_telegram_id' => '232323',
        ]);

        $response->assertStatus(200);

        $response->assertSee('price');
    }

    public function test_delete_bid_work()
    {
        $this->create_data();

        $bid = $this->get_one_bid();

        $response = $this->delete('api/telegram/bids/delete', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '232323',
        ]);

        $response->assertStatus(200);
    }

    public function test_ask_bid_work()
    {
        $this->create_data();

        $bid = $this->get_one_bid();

        $response = $this->post('api/telegram/bids/ask', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '2323233434',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('bids', ['uuid' => $bid->uuid, 'status' => 'asked']);
    }

    public function test_show_bid_work()
    {
        $this->create_data();

        $bid = $this->get_one_bid();

        $response = $this->post('api/telegram/bids/show', [
            'uuid' => $bid->uuid,
        ]);

        $response->assertStatus(200);

        $response->assertSee('price');
    }
}
