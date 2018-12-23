<?php

namespace App\Letgo\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoutControllerTest extends WebTestCase
{
    public function testSuccess()
    {
        $client = static::createClient();
        $client->request('GET', '/shout/realDonaldTrump?limit=2');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(2, count(json_decode($client->getResponse()->getContent())));
    }

    public function testSuccessWithMaxLimit()
    {
        $client = static::createClient();
        $client->request('GET', '/shout/realDonaldTrump?limit=10');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(10, count(json_decode($client->getResponse()->getContent())));
    }

    public function testSuccessWithMinLimit()
    {
        $client = static::createClient();
        $client->request('GET', '/shout/realDonaldTrump?limit=1');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(1, count(json_decode($client->getResponse()->getContent())));
    }

    public function testPageNotFound()
    {
        $client = static::createClient();

        //These avoids showing debug information in the test output
        $client->catchExceptions(false);
        $this->expectException(NotFoundHttpException::class);

        $client->request('GET', '/misspelling/realDonaldTrump?limit=2');
        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testFailedMaxConstraints()
    {
        $client = static::createClient();
        $client->request('GET', '/shout/realDonaldTrump?limit=11');

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $client->getResponse()->getStatusCode());
    }

    public function testFailedMinConstraints()
    {
        $client = static::createClient();
        $client->request('GET', '/shout/realDonaldTrump?limit=0');
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $client->getResponse()->getStatusCode());
    }

    public function testFailedWrongLimit()
    {
        $client = static::createClient();
        $client->request('GET', '/shout/realDonaldTrump?limit=notDigit');
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $client->getResponse()->getStatusCode());
    }

    public function testFailedEmptyTwitterName()
    {
        $client = static::createClient();

        //These avoids showing debug information in the test output
        $client->catchExceptions(false);
        $this->expectException(NotFoundHttpException::class);

        $client->request('GET', '/shout/?limit=5');
        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}