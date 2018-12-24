<?php

namespace App\Letgo\Infrastructure;

class TweetRepositoryStaticFactory
{
    public static function createRepository(TweetRepositoryInMemory $repo)
    {
        $cacheLayer = $_SERVER['CACHE_LAYER'];
        if ($cacheLayer) {
            $expiresAfter = $_SERVER['CACHE_EXPIRES_AFTER'];
            $cacheFolder = $_SERVER['CACHE_FOLDER'];
            $tweetRepository = new CachedTweetRepository($repo, (new FilesystemCachedRepository($expiresAfter, $cacheFolder)));
        } else {
            $tweetRepository = $repo;
        }

        return $tweetRepository;
    }
}