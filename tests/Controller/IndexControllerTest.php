<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testCalculatePrice()
    {
        $client = $this->createClient();

        $client->request('POST', '/calculate-price', content: '{"product":"1", "taxNumber":"GR123456789"}');
        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{"price":124}', $client->getResponse()->getContent());
    }

    public function testCalculatePriceWithCoupon()
    {
        $client = $this->createClient();

        $client->request('POST', '/calculate-price', content: '{"product":"1", "taxNumber":"GR123456789", "couponCode":"CS002"}');
        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{"price":116.56}', $client->getResponse()->getContent());
    }

    public function testCalculatePriceVATNumberError()
    {
        $client = $this->createClient();

        $client->request('POST', '/calculate-price', content: '{"product":"1", "taxNumber":"TEST", "couponCode":"CS002"}');
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString('{"error":"Invalid VATNumber"}', $client->getResponse()->getContent());
    }
}
