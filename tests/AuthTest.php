<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $response = $this->post('/login',[
            'usuario'   => 'admin',
            'pass'      => 'secreto'
        ]);

        $response->isJson();
        $response->seeStatusCode(201);
        $json = json_decode($response->response->content());
        return $json->token;
    }

    public function testLogout()
    {
        $token = $this->testLogin();
        $response = $this->post('/logout',[
            'usuario'   => 'admin',
            'pass'      => 'secreto'
        ],[
            'Auth-Token'    => $token
        ]);
        $response->isJson();
        $response->seeStatusCode(200);
    }
}