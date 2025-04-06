<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaseControllerTest extends WebTestCase
{
    public function testPurchase(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/purchase',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'product' => 1,
                'taxNumber' => 'IT12345678900',
                'paymentProcessor' => 'paypal'
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function testInvalidPaymentProcessor(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/purchase',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'product' => 1,
                'taxNumber' => 'IT12345678900',
                'paymentProcessor' => 'invalid'
            ])
        );

        $this->assertResponseStatusCodeSame(400);
    }
}