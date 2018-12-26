<?php

namespace App\Tests\Letgo\Infrastructure;

use PHPUnit\Framework\TestCase;
use App\Letgo\Domain\Tweet;
use App\Letgo\Infrastructure\FilesystemCachedRepository;

class FilesystemCachedRepositoryTest extends TestCase
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
        $this->cachedRepository->setExpiresAfter(30);
        $this->cachedRepository->save($this->username, $this->getSampleTweets());
        $tweetsFromCache = $this->cachedRepository->get($this->username);
        $this->assertEquals($tweetsFromCache, $this->getSampleTweets());
    }

    public function testGetNotSavedItems()
    {
        $tweetsFromCache = $this->cachedRepository->get($this->username);
        $this->assertEquals($tweetsFromCache, []);
    }

    public function testGetNotExpiredItems()
    {
        $this->cachedRepository->setExpiresAfter(2);
        $this->cachedRepository->save($this->username, $this->getSampleTweets());

        sleep(1);

        $tweetsFromCache = $this->cachedRepository->get($this->username);
        $this->assertEquals($tweetsFromCache, $this->getSampleTweets());
    }

    public function testGetExpiredItems()
    {
        $this->cachedRepository->setExpiresAfter(1);
        $this->cachedRepository->save($this->username, $this->getSampleTweets());

        sleep(2);

        $tweetsFromCache = $this->cachedRepository->get($this->username);
        $this->assertEquals($tweetsFromCache, []);
    }

    public function testHasItem()
    {
        $this->assertFalse($this->cachedRepository->hasItem($this->username));
        $this->cachedRepository->save($this->username, $this->getSampleTweets());
        $this->assertTrue($this->cachedRepository->hasItem($this->username));
    }

    private function getSampleTweets()
    {
        return [
            new Tweet('TWEET 1!'),
            new Tweet('TWEET 2!'),
            new Tweet('TWEET 3!')
        ];
    }
}
