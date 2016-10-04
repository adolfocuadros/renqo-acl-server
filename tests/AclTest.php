<?php

class AclTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAclCheck()
    {
        $response = $this->post('/login',[
            'usuario'   => 'admin',
            'pass'      => 'secreto'
        ]);
        $json = json_decode($response->response->content());
        $token = $json->token;

        $response = $this->post('/acl',[
            'permission'    => 'permission.test'
        ],[
            'Auth-Token'    => $token
        ]);

        $response->isJson();
        $response->seeStatusCode(200);
    }
}