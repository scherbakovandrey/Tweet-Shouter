<?php

namespace App\Letgo\Tests\Domain;

use PHPUnit\Framework\TestCase;
use App\Letgo\Infrastructure\FilesystemCachedRepository;

class CachedRepositoryTest extends TestCase
{
    public function testSaveItems()
    {
        $cache = new FilesystemCachedRepository();
        $cache->clear();
        $cache->setExpiresAfter(30);
        $username = 'realDonaldTrump';
        $cache->save($username, $this->getSampleFormattedTweets());
        $formattedTweetsFromCache = $cache->get($username);
        $this->assertEquals($formattedTweetsFromCache, $this->getSampleFormattedTweets());
    }

    public function testGetNotSavedItems()
    {
        $cache = new FilesystemCachedRepository();
        $cache->clear();
        $username = 'realDonaldTrump';
        $formattedTweetsFromCache = $cache->get($username);
        $this->assertEquals($formattedTweetsFromCache, []);
    }

    /*

    public function testGetNotExpiredItems()
    {
        $cache = new FilesystemCachedRepository();
        $cache->setExpiresAfter(2);
        $username = 'realDonaldTrump';
        $cache->save($username, $this->getSampleFormattedTweets());
        sleep(1);
        $formattedTweetsFromCache = $cache->get($username);
        $this->assertEquals($formattedTweetsFromCache, $this->getSampleFormattedTweets());
    }

    public function testGetExpiredItems()
    {
        $cache = new FilesystemCachedRepository();
        $cache->setExpiresAfter(1);
        $username = 'realDonaldTrump';
        $cache->save($username, $this->getSampleFormattedTweets());
        sleep(2);
        $formattedTweetsFromCache = $cache->get($username);
        $this->assertEquals($formattedTweetsFromCache, []);
    }

    */

    private function getSampleFormattedTweets()
    {
        return [
            'TWEET 1!',
            'TWEET 2!',
            'TWEET 3!'
        ];
    }
}
