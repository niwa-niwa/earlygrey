<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;


    public $user_info = array(
        "name" => 'niwayama',
        "email" => "urban.hang274@gmail.com",
        "password" => "t4169N5175",
    );


    public function setUp() : void
    {
        parent::setUp();
    }


    private function register(){
        $response = $this->post('api/v1/auth/register', $this->user_info);
        return $response;
    }

    private function login(){
        $response = $this->post('api/v1/auth/login', $this->user_info );
        return $response;
    }


    /*
    * Start test
    */


    public function test_register(){
        $response = $this->register();
        $response->assertStatus(200);
    }


    public function test_register_error(){
        
        $this->register();

        $response = $this->post('api/v1/auth/register', $this->user_info);

        $response->assertStatus(400);
    }


    public function test_login()
    {
        $this->register();

        $response = $this->login();

        $response->assertStatus(200);
    }


    public function test_logout()
    {
        $this->register();

        $this->login();

        $response = $this->post('api/v1/auth/logout');

        $response->assertStatus(200);
    }


    public function test_refresh()
    {
        $response = $this->register();
        $response = $this->login();
        $data = $response->getContent();
        $token = json_decode($data)->access_token;

        $response = $this->post('api/v1/auth/refresh',
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept' => 'application/json',
                ],
            ]
        );

        $response->assertStatus(200);

    }
}
