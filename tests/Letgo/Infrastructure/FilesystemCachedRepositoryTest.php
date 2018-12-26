<?php

namespace App\Tests\Letgo\Infrastructure;

use PHPUnit\Framework\TestCase;
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
        $this->cachedRepository->save($this->username, $this->getSampleFormattedTweets());
        $formattedTweetsFromCache = $this->cachedRepository->get($this->username);
        $this->assertEquals($formattedTweetsFromCache, $this->getSampleFormattedTweets());
    }

    public function testGetNotSavedItems()
    {
        $formattedTweetsFromCache = $this->cachedRepository->get($this->username);
        $this->assertEquals($formattedTweetsFromCache, []);
    }

    public function testGetNotExpiredItems()
    {
        $this->cachedRepository->setExpiresAfter(2);
        $this->cachedRepository->save($this->username, $this->getSampleFormattedTweets());
        sleep(1);
        $formattedTweetsFromCache = $this->cachedRepository->get($this->username);
        $this->assertEquals($formattedTweetsFromCache, $this->getSampleFormattedTweets());
    }

    public function testGetExpiredItems()
    {
        $this->cachedRepository->setExpiresAfter(1);
        $this->cachedRepository->save($this->username, $this->getSampleFormattedTweets());

        sleep(2);

        $formattedTweetsFromCache = $this->cachedRepository->get($this->username);
        $this->assertEquals($formattedTweetsFromCache, []);
    }

    public function testHasItem()
    {
        $this->assertFalse($this->cachedRepository->hasItem($this->username));
        $this->cachedRepository->save($this->username, $this->getSampleFormattedTweets());
        $this->assertTrue($this->cachedRepository->hasItem($this->username));
    }

    private function getSampleFormattedTweets()
    {
        return [
            'TWEET 1!',
            'TWEET 2!',
            'TWEET 3!'
        ];
    }
}
