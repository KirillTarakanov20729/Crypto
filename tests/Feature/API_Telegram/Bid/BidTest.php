<?php

namespace Tests\Feature\API_Telegram\Bid;

use App\Models\Payment;
use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
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

        $response = $this->post('api/telegram/bids/showUserBids', [
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

        $this->assertDatabaseHas('payments', ['request_user_telegram_id' => '2323233434']);
    }

    public function test_response_bid_work()
    {
        $this->create_data();

        $bid = $this->get_one_bid();

        $response = $this->post('api/telegram/bids/ask', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '2323233434',
        ]);

        $response->assertStatus(200);

        $response = $this->post('api/telegram/bids/response', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '232323',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('bids', ['uuid' => $bid->uuid, 'status' => 'response']);

        $this->assertDatabaseHas('payments', ['request_user_telegram_id' => '2323233434']);
    }

    public function test_pay_bid_work()
    {
        $this->create_data();

        $bid = $this->get_one_bid();

        $response = $this->post('api/telegram/bids/ask', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '2323233434',
        ]);

        $payment = $response['data']['payment']['uuid'];

        $response->assertStatus(200);

        $response = $this->post('api/telegram/bids/response', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '232323',
        ]);

        $response = $this->post('api/telegram/bids/pay', [
            'uuid' => $payment,
            'user_telegram_id' => '232323',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('bids', ['uuid' => $bid->uuid, 'status' => 'paid']);

        $this->assertDatabaseHas('payments', ['request_user_telegram_id' => '2323233434']);
    }

    public function test_cancel_bid_work()
    {
        $this->create_data();

        $bid = $this->get_one_bid();

        $response = $this->post('api/telegram/bids/ask', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '2323233434',
        ]);

        $response->assertStatus(200);

        $payment = $response['data']['payment']['uuid'];

        $response = $this->post('api/telegram/bids/cancel', [
            'uuid' => $payment,
            'user_telegram_id' => '2323233434',
        ]);

        $response->assertStatus(200);


        $this->assertDatabaseHas('bids', ['uuid' => $bid->uuid, 'status' => 'created']);
    }

    public function test_cancel_bid_work_if_bid_paid()
    {
        $this->create_data();

        $bid = $this->get_one_bid();

        $response = $this->post('api/telegram/bids/ask', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '2323233434',
        ]);

        $response->assertStatus(200);

        $payment = $response['data']['payment']['uuid'];


        $response = $this->post('api/telegram/bids/response', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '232323',
        ]);

        $response = $this->post('api/telegram/bids/pay', [
            'uuid' => $payment,
            'user_telegram_id' => '232323',
        ]);

        $response = $this->post('api/telegram/bids/cancel', [
            'uuid' => $payment,
            'user_telegram_id' => '2323233434',
        ]);

        $response->assertStatus(404);

        $this->assertDatabaseHas('bids', ['uuid' => $bid->uuid, 'status' => 'paid']);
    }

    public function test_another_user_cant_cancel_bid()
    {
        $this->create_data();

        $bid = $this->get_one_bid();

        $response = $this->post('api/telegram/bids/ask', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '2323233434',
        ]);

        $response->assertStatus(200);

        $payment = $response['data']['payment']['uuid'];


        $response = $this->post('api/telegram/bids/response', [
            'uuid' => $bid->uuid,
            'user_telegram_id' => '232323',
        ]);

        $response = $this->post('api/telegram/bids/pay', [
            'uuid' => $payment,
            'user_telegram_id' => '232323',
        ]);

        $response = $this->post('api/telegram/bids/cancel', [
            'uuid' => $payment,
            'user_telegram_id' => '23232334342342',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('bids', ['uuid' => $bid->uuid, 'status' => 'paid']);
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
