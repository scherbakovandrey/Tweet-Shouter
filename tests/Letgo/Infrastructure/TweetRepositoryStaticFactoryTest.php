<?php

namespace App\Tests\Letgo\Infrastructure;

use PHPUnit\Framework\TestCase;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use App\Letgo\Infrastructure\TweetRepositoryStaticFactory;
use App\Letgo\Infrastructure\CachedTweetRepository;

class TweetRepositoryStaticFactoryTest extends TestCase
{
    public function testCreateRepositoryWithoutCacheLayer()
    {
        $_SERVER['CACHE_LAYER'] = false;
        $repository = TweetRepositoryStaticFactory::createRepository(new TweetRepositoryInMemory());
        $this->assertTrue($repository instanceof TweetRepositoryInMemory);
    }

    public function testCreateRepositoryWithCacheLayer()
    {
        $_SERVER['CACHE_LAYER'] = true;
        $repository = TweetRepositoryStaticFactory::createRepository(new TweetRepositoryInMemory());
        $this->assertTrue($repository instanceof CachedTweetRepository);
    }
}
