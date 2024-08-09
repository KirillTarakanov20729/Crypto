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
        ]);

        $response->assertStatus(200);

        $response->assertSee('price');
    }
}
