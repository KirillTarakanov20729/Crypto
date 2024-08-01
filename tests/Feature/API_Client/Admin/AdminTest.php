<?php

namespace Tests\Feature\API_Client\Admin;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

    public function test_admin_index_work()
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

        $response = $this->post('api/client/admins/index', [
            'page' => 1
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('admin_one@mail.ru');
    }

    public function test_admin_show_work()
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

        $response = $this->get('api/client/admins/show/2', [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $response->assertSee('admin_one@mail.ru');
    }

    public function test_admin_store_work()
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

        $response = $this->post('api/client/admins/store', [
            'email' => 'admin_three@mail.ru',
            'password' => 'admin1234'
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('admins', [
            'email' => 'admin_three@mail.ru',
        ]);
    }

    public function test_admin_update_work()
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

        $response = $this->put('api/client/admins/update', [
            'id' => 2,
            'email' => 'admin_two_update@mail.ru',
            'password' => 'admin1234'
        ], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('admins', [
            'email' => 'admin_two_update@mail.ru',
        ]);
    }

    public function test_admin_delete_work()
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

        $response = $this->delete('api/client/admins/delete/2', [], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('admins', [
            'id' => 2
        ]);

    }
}
