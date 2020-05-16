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

        $client->request(
            'POST',
            '/api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
//            '{"username":"admin", "email":"admin@admin.admin","password":"admin"}'
            '{"username": "admin'.$randomize.'", "email": "admin'.$randomize.'@admin.admin", "password":"admin", "photoUrl": "profile.jpg", "roles": { "0": "ROLE_USER", "1": "ROLE_ADMIN" }}'
        );

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('/api/auth/view-user/', $client->getResponse()->getTargetUrl());
    }
}
