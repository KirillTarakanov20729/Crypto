<?php

namespace Tests\Feature\API_Telegram\Balance;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_get_balance_work()
    {
        $this->create_data();

        $response = $this->get('api/telegram/balance/show/232323');

        $response->assertStatus(200);
    }
}
