<?php

namespace Tests\Feature\API_Client\User;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_user_index_work(): void
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

        $response = $this->post('api/client/users/index', [
            'page' => 1
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('User One');
    }

    public function test_user_store_work(): void
    {
        $user = $this->create_admin_user();

        $this->actingAs($user, 'api');

        $response = $this->post('api/client/auth/login', [
            'email' => $user->email,
            'password' => 'admin1234',
        ]);

        $accessToken = $response->json('access_token');

        $response->assertStatus(200);

        $response = $this->post('api/client/users/store', [
            'name' => 'User Three',
            'email' => 'user3@mail.ru',
            'password' => 'user1234',
            'telegram_id' => '2323233434'
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => 'User Three'
        ]);
    }

    public function test_user_update_work(): void
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

        $response = $this->put('api/client/users/update', [
            'id' => 1,
            'name' => 'User One New',
            'email' => 'user@mail.ru',
            'password' => 'user1234',
            'telegram_id' => '232323',
            'is_logged_in' => 1
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => 'User One New'
        ]);
    }

    public function test_user_delete_work(): void
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

        $response = $this->delete('api/client/users/delete', [
            'id' => 1
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'id' => 1
        ]);
    }
}
