<?php

namespace Tests\Feature\API_Client\Auth;

use App\Traits\Tests\CreateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    use CreateData;

   public function test_login_work(): void
   {
       $this->create_admin_user();

       $response = $this->post('api/client/auth/login', [
           'email' => 'admin@mail.ru',
           'password' => 'admin1234',
       ]);

       $response->assertJsonStructure([
           'access_token',
       ]);

       $response->assertStatus(200);
   }

   public function test_login_fail(): void
   {
       $this->create_admin_user();

       $response = $this->post('api/client/auth/login', [
           'email' => 'admin@mail.ru',
           'password' => 'admin12345',
       ]);

       $response->assertStatus(401);
   }

   public function test_admins_requests_dont_work_without_jwt_token(): void
   {
       $this->create_admin_user();

       $response = $this->post('api/client/coins/index', [
           'page' => 1
       ]);

       $response->assertStatus(401);
   }
}
