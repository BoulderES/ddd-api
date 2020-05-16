<?php


namespace Cuadrik\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    /** @test */
    public function registerUserTest()
    {
        $client = static::createClient();
        $randomize = rand(0,9999999);

        $username = "admin".$randomize;
        $email = "admin'.$randomize.'@admin.admin";

//        $client->request('POST','/api/register',[],[],['CONTENT_TYPE' => 'application/json'],'{"username":"admin", "email":"admin@admin.admin","password":"admin", "photoUrl": "profile.jpg", "roles": { "0": "ROLE_USER", "1": "ROLE_ADMIN" }}');
        $client->request('POST','/api/register',[],[],['CONTENT_TYPE' => 'application/json'],'{"username": "'.$username.'", "email": "'.$email.'", "password":"admin", "photoUrl": "profile.jpg", "roles": { "0": "ROLE_USER", "1": "ROLE_ADMIN" }}');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('/api/auth/view-user/', $client->getResponse()->getTargetUrl());

//        $client->request('POST','/api/login',[],[],['CONTENT_TYPE' => 'application/json'],            '{"username":"admin", "email":"admin@admin.admin","password":"admin"}');
        $client->request('POST','/api/login',[],[],['CONTENT_TYPE' => 'application/json'],'{"username": "'.$username.'", "password":"admin"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());


//        $content = json_decode($client->getResponse()->getContent(), false);
//        var_export($content);
//        $client->request('POST','/api/auth/refresh-token',[],[],['CONTENT_TYPE' => 'application/json'],'{"token":"' . $content->token . '"}');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());


        $client->request('POST','/api/auth/refresh-token',[],[],['CONTENT_TYPE' => 'application/json'],'{"token":"fake_token"}');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $client->request('POST','/api/login',[],[],['CONTENT_TYPE' => 'application/json'],'{"username": "'.$username.'", "password":"bad_password"}');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $client->request('POST','/api/login',[],[],['CONTENT_TYPE' => 'application/json'],'{"username": "bad_username", "password":"bad_password"}');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());

    }
}
