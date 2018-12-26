<?php

namespace App\Tests\Letgo\Infrastructure;

use PHPUnit\Framework\TestCase;
use App\Letgo\Infrastructure\FilesystemCachedRepository;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use App\Letgo\Infrastructure\CachedTweetRepository;

class CachedTweetRepositoryTest extends TestCase
{
    public function testSaveItems()
    {
        $cachedRepository = new FilesystemCachedRepository();
        $cachedRepository->clear();

        $cachedTweetRepository = new CachedTweetRepository(new TweetRepositoryInMemory(), $cachedRepository);
        $username = 'realDonaldTrump';

        $tweets = $cachedTweetRepository->searchByUserName($username, 10);
        $this->assertEquals(count($tweets), 10);
        $tweetsFromCache = $cachedRepository->get(CachedTweetRepository::$cacheNamespace . $username);

        $this->assertEquals($tweets, $tweetsFromCache);
    }

    public function testGetItemsTwice()
    {
        $cachedRepository = new FilesystemCachedRepository();
        $cachedRepository->clear();

        $cachedTweetRepository = new CachedTweetRepository(new TweetRepositoryInMemory(), $cachedRepository);
        $username = 'realDonaldTrump';

        $tweetsFromCache = $cachedRepository->get(CachedTweetRepository::$cacheNamespace . $username);
        $this->assertEquals(count($tweetsFromCache), 0);

        $tweetsFromApi = $cachedTweetRepository->searchByUserName($username, 5);
        $this->assertEquals(count($tweetsFromApi), 5);

        $tweetsFromCache = $cachedRepository->get(CachedTweetRepository::$cacheNamespace . $username);
        $this->assertEquals(count($tweetsFromCache), 5);

        $tweetsFromCachedRepository = $cachedTweetRepository->searchByUserName($username, 5);
        $this->assertEquals(count($tweetsFromCachedRepository), 5);

        $this->assertEquals($tweetsFromApi, $tweetsFromCachedRepository);
    }

    public function testGetItemsTwiceTimeIsOver()
    {
        $cachedRepository = new FilesystemCachedRepository();
        $cachedRepository->setExpiresAfter(1);
        $cachedRepository->clear();

        $cachedTweetRepository = new CachedTweetRepository(new TweetRepositoryInMemory(), $cachedRepository);
        $username = 'realDonaldTrump';

        $tweetsFromCache = $cachedRepository->get(CachedTweetRepository::$cacheNamespace . $username);
        $this->assertEquals(count($tweetsFromCache), 0);

        $tweetsFromApi = $cachedTweetRepository->searchByUserName($username, 5);
        $this->assertEquals(count($tweetsFromApi), 5);

        $tweetsFromCache = $cachedRepository->get(CachedTweetRepository::$cacheNamespace . $username);
        $this->assertEquals(count($tweetsFromCache), 5);

        sleep(2);

        $tweetsFromCachedRepository = $cachedTweetRepository->searchByUserName($username, 5);
        $this->assertEquals(count($tweetsFromCachedRepository), 5);

        $this->assertNotEquals($tweetsFromApi, $tweetsFromCachedRepository);
    }
}