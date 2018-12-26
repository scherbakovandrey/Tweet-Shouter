<?php

namespace App\Tests\Letgo\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Letgo\Application\ShoutApp;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use Symfony\Component\HttpFoundation\Response;

class ShoutAppTest extends WebTestCase
{
    public function testShoutSuccess()
    {
        $apiResponse = (new ShoutApp())->shout(new TweetRepositoryInMemory(), 'realDonaldTrump', 5);
        $this->assertEquals($apiResponse['status'], Response::HTTP_OK);
        $this->assertEquals($apiResponse['error'], '');
        $this->assertEquals(count($apiResponse['tweets']), 5);
    }

    public function testShoutUsernameNotFound()
    {
        $tweetRepositoryMock = \Mockery::mock('App\Letgo\Infrastructure\TweetRepositoryInMemory');
        $tweetRepositoryMock->shouldReceive('searchByUserName')->once()->andReturn([]);
        $apiResponse = (new ShoutApp())->shout($tweetRepositoryMock, 'wrongUsername', 5);
        $this->assertEquals($apiResponse['status'], Response::HTTP_NOT_FOUND);
        $this->assertEquals($apiResponse['error'], 'Sorry, the requested resource doesn\'t exist.');
    }

    public function testFailedShoutZeroLimit()
    {
        $apiResponse = (new ShoutApp())->shout(new TweetRepositoryInMemory(), 'realDonaldTrump', 0);
        $this->assertEquals($apiResponse['status'], Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertEquals($apiResponse['error'], 'Limit parameter MUST be equal or less than 10.');
    }

    public function testFailedShoutLimitExceed()
    {
        $apiResponse = (new ShoutApp())->shout(new TweetRepositoryInMemory(), 'realDonaldTrump', 11);
        $this->assertEquals($apiResponse['status'], Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertEquals($apiResponse['error'], 'Limit parameter MUST be equal or less than 10.');
    }
}