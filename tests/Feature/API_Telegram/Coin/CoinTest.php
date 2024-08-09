<?php

namespace Tests\Feature\API_Telegram\Coin;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoinTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_get_coins_work()
    {
        $this->create_data();

        $response = $this->get('api/telegram/coins/all');

        $response->assertStatus(200);
    }
}
