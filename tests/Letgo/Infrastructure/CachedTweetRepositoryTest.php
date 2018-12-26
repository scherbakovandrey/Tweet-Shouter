<?php

namespace App\Tests\Letgo\Infrastructure;

use PHPUnit\Framework\TestCase;
use App\Letgo\Infrastructure\FilesystemCachedRepository;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use App\Letgo\Infrastructure\CachedTweetRepository;

class CachedTweetRepositoryTest extends TestCase
{
    private $cachedRepository;

    private $username = 'realDonaldTrump';

    protected function setUp()
    {
        $this->cachedRepository = new FilesystemCachedRepository();
        $this->cachedRepository->clear();
    }

    public function testSaveItems()
    {
        $cachedTweetRepository = new CachedTweetRepository(new TweetRepositoryInMemory(), $this->cachedRepository);

        $tweets = $cachedTweetRepository->searchByUserName($this->username, 10);
        $this->assertEquals(count($tweets), 10);
        $tweetsFromCache = $this->cachedRepository->get(CachedTweetRepository::$cacheNamespace . $this->username);

        $this->assertEquals($tweets, $tweetsFromCache);
    }

    public function testGetItemsTwice()
    {
        $cachedTweetRepository = new CachedTweetRepository(new TweetRepositoryInMemory(), $this->cachedRepository);

        $tweetsFromCache = $this->cachedRepository->get(CachedTweetRepository::$cacheNamespace . $this->username);
        $this->assertEquals(count($tweetsFromCache), 0);

        $tweetsFromApi = $cachedTweetRepository->searchByUserName($this->username, 5);
        $this->assertEquals(count($tweetsFromApi), 5);

        $tweetsFromCache = $this->cachedRepository->get(CachedTweetRepository::$cacheNamespace . $this->username);
        $this->assertEquals(count($tweetsFromCache), 5);

        $tweetsFromCachedRepository = $cachedTweetRepository->searchByUserName($this->username, 5);
        $this->assertEquals(count($tweetsFromCachedRepository), 5);

        $this->assertEquals($tweetsFromApi, $tweetsFromCachedRepository);
    }

    public function testGetItemsTwiceTimeIsOver()
    {
        $this->cachedRepository->setExpiresAfter(1);

        $cachedTweetRepository = new CachedTweetRepository(new TweetRepositoryInMemory(), $this->cachedRepository);

        $tweetsFromCache = $this->cachedRepository->get(CachedTweetRepository::$cacheNamespace . $this->username);
        $this->assertEquals(count($tweetsFromCache), 0);

        $tweetsFromApi = $cachedTweetRepository->searchByUserName($this->username, 5);
        $this->assertEquals(count($tweetsFromApi), 5);

        $tweetsFromCache = $this->cachedRepository->get(CachedTweetRepository::$cacheNamespace . $this->username);
        $this->assertEquals(count($tweetsFromCache), 5);

        sleep(2);

        $tweetsFromCachedRepository = $cachedTweetRepository->searchByUserName($this->username, 5);
        $this->assertEquals(count($tweetsFromCachedRepository), 5);

        $this->assertNotEquals($tweetsFromApi, $tweetsFromCachedRepository);
    }

    public function testNotEnoughTweetsInCache()
    {
        $cachedTweetRepository = new CachedTweetRepository(new TweetRepositoryInMemory(), $this->cachedRepository);

        $tweetsFromCache = $this->cachedRepository->get(CachedTweetRepository::$cacheNamespace . $this->username);
        $this->assertEquals(count($tweetsFromCache), 0);

        $tweetsFromApi = $cachedTweetRepository->searchByUserName($this->username, 5);
        $this->assertEquals(count($tweetsFromApi), 5);

        $tweetsFromCache = $this->cachedRepository->get(CachedTweetRepository::$cacheNamespace . $this->username);
        $this->assertEquals(count($tweetsFromCache), 5);

        $tweetsFromCachedRepository = $cachedTweetRepository->searchByUserName($this->username, 6);
        $this->assertEquals(count($tweetsFromCachedRepository), 6);

        $this->assertNotEquals($tweetsFromApi, $tweetsFromCachedRepository);
    }
}