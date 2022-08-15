<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_login(){
        //create user
          $user = User::factory()->create();
        //login

        $this->post('login',[
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();
    }
}
