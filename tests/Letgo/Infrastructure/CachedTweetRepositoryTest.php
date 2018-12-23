<?php

namespace App\Letgo\Tests\Domain;

use PHPUnit\Framework\TestCase;
use App\Letgo\Infrastructure\FilesystemCachedRepository;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use App\Letgo\Infrastructure\CachedTweetRepository;

class CachedTweetRepositoryTest extends TestCase
{
    public function testSaveItems()
    {
        $cachedRepository = new FilesystemCachedRepository(10);

        $cachedTweetRepository = new CachedTweetRepository(new TweetRepositoryInMemory(), $cachedRepository);
        $username = 'realDonaldTrump';

        $this->assertFalse($cachedTweetRepository->hasItem($username));

        $tweets = $cachedTweetRepository->searchByUserName($username, 10);
        $this->assertEquals(count($tweets), 10);
        $this->assertTrue($cachedTweetRepository->hasItem($username));
    }

    //TODO Add more tests to check the cache logic
}