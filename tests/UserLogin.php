<?php
namespace Tests;
use App\Models\User;

trait UserLogin{
    public $user;

    public function setUpUser(){
        //create user
        $this->user = User::factory()->create();

        //login user
        $this->post('login',[
            'email' => $this->user->email,
            'password' => 'password',
            'role' => 0
        ]);
    }

    public function setUpAdminUser(){
        //create user
        $this->user = User::factory()->create();

        //login user
        $this->post('login',[
            'email' => $this->user->email,
            'password' => 'password',
            'role' => 1
        ]);
    }
}
