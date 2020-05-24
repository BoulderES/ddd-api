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
        $this->assertStringContainsString('/api/auth/project-user/', $client->getResponse()->getTargetUrl());

//        $client->request('POST','/api/login',[],[],['CONTENT_TYPE' => 'application/json'],            '{"username":"admin", "email":"admin@admin.admin","password":"admin"}');
        $client->request('POST','/api/login',[],[],['CONTENT_TYPE' => 'application/json'],'{"username": "'.$username.'", "password":"admin"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());


//        $content = json_decode($client->getResponse()->getContent(), false);
//        var_export($content);
//        $client->request('POST','/api/auth/refresh-token',[],[],['CONTENT_TYPE' => 'application/json'],'{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1ODk2NDE3NzIsImV4cCI6MTU4OTY0NTM3Miwicm9sZXMiOlsiUk9MRV9SRUdVTEFSIiwiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYWRtaW4iLCJ1dWlkIjoiYmJmOTEzYTgtMTU1ZC00ZDA5LTg3MTMtZTEzYzRmOWM2YzJhIiwiaXAiOiIxNzIuMjUuMC4xIn0.k7dDBdFnhPlBy2NRA3XZZ9tL1RygT7kRP-KpQQr-faxDbrC_QwRHDpXgZod3vkpEXlCTKCGYwqMKtKaFZlJ9eIzP2bFEB0lSYUuZ7MZVZFELOAMNyjH3fxjGCBpY-vKaCe3c2FRb27LntNm5DerYBAJUjdxmeo_5ouiuS3QBYq82JRh8iTKBqhSD9uqgymGveQuvK4yJm8LELz16tWEMpncChpL7JGKX4IG8ttVlT1H9fxTStLAcjYt0RJoXeeYdlqfXUNpUpn7ptiTPQsyVRcyLrfpQHa-hailBmNrO4Aova9W9MKKVLwgYpTn1UFriCPsNtQF1G76PK8uMt05J2Mfg5OniwtzxBF8o-0FyUFVmZOQPj2-bbZbZT9CcxgVd9vqnJSYozmMXD13iuECg-qFWygfbvX51QdJiBdMKldlKUuJtg6M0puJ3NF7Us8vh0F11tuo6jDDItDA0COrppfYpgEHcXEk-R5MQOSsM9fiIYgShz7qqDVfg1fcYYd1YwokH5YPnbjjUscMG9v6AJLTSq2VQ0Ia7uQXEQ1bcmZOkzelVP2GfFMt5HQ2vsY3u8_JmRRDtOoSUbbbpUruPeAz3FeFhOTOyQXXewoNARUip9Mc3gCLO5XLbaqFwB6OPquAoGg5VL8h_Dw05JsAanvyPp-G3gPHfxA2WQVqI9Xw"}');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());


        $client->request('POST','/api/auth/refresh-token',[],[],['CONTENT_TYPE' => 'application/json'],'{"token":"fake_token"}');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $client->request('POST','/api/login',[],[],['CONTENT_TYPE' => 'application/json'],'{"username": "'.$username.'", "password":"bad_password"}');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $client->request('POST','/api/login',[],[],['CONTENT_TYPE' => 'application/json'],'{"username": "bad_username", "password":"bad_password"}');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());

    }
}
