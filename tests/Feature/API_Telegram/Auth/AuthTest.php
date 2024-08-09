<?php

namespace Tests\Feature\API_Telegram\Auth;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;
    public function test_register_work()
    {
        $this->create_data();

        $response = $this->post('api/telegram/auth/register', [
            'email' => 'test@mail.ru',
            'password' => 'admin1234',
            'name' => 'test',
            'telegram_id' => '1233434',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'test@mail.ru',
        ]);
    }

    public function test_register_fail()
    {
        $response = $this->post('api/telegram/auth/register', [
            'password' => 'admin1234',
            'name' => 'test',
            'telegram_id' => '1233434',
        ]);

        $response->assertStatus(422);
    }

    public function test_login_work()
    {
        $this->create_telegram_user();

        $response = $this->post('api/telegram/auth/login', [
            'email' => 'telegram@mail.ru',
            'password' => 'telegram1234',
            'telegram_id' => '232323',
        ]);

        $response->assertStatus(200);
    }

    public function test_login_fail()
    {
        $this->create_telegram_user();

        $response = $this->post('api/telegram/auth/login', [
            'email' => 'telegram@mail.ru',
            'password' => 'telegram12345',
            'telegram_id' => '232323',
        ]);

        $response->assertStatus(401);
    }

    public function test_login_fail_if_telegram_id_wrong()
    {
        $this->create_telegram_user();

        $response = $this->post('api/telegram/auth/login', [
            'email' => 'telegram@mail.ru',
            'password' => 'telegram1234',
            'telegram_id' => '2323233434',
        ]);

        $response->assertStatus(401)
            ->assertJsonFragment(['error' => 'Telegram ID is incorrect']);
    }
}
