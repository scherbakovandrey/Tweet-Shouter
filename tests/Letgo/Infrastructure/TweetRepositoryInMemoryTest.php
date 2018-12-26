<?php

namespace App\Tests\Letgo\Infrastructure;

use App\Letgo\Domain\Tweet;
use PHPUnit\Framework\TestCase;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;

class TweetRepositoryInMemoryTest extends TestCase
{
    public function testCreateRepository()
    {
        $repo = new TweetRepositoryInMemory();
        $this->assertTrue($repo instanceof TweetRepositoryInMemory);
    }

    public function testSearchByUserName()
    {
        $tweets = (new TweetRepositoryInMemory())->searchByUserName('realDonaldTrump', 2);
        $this->assertEquals(2, count($tweets));
        $this->assertTrue($tweets[0] instanceof Tweet);
        $this->assertTrue($tweets[1] instanceof Tweet);
    }

    public function testSearchByUserNameWithOneTweet()
    {
        $tweets = (new TweetRepositoryInMemory())->searchByUserName('realDonaldTrump', 1);
        $this->assertEquals(1, count($tweets));
        $this->assertTrue($tweets[0] instanceof Tweet);
    }
}