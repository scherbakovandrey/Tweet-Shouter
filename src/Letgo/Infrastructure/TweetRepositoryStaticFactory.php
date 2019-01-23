<?php

namespace App\Letgo\Infrastructure;

class TweetRepositoryStaticFactory
{
    public static function createRepository(TweetRepositoryInMemory $repo)
    {
        $cacheLayer = getenv('CACHE_LAYER');
        if ($cacheLayer) {
            $expiresAfter = getenv('CACHE_EXPIRES_AFTER');
            $cacheFolder = getenv('CACHE_FOLDER');
            $tweetRepository = new CachedTweetRepository($repo, (new FilesystemCachedRepository('', $expiresAfter, $cacheFolder)));
        } else {
            $tweetRepository = $repo;
        }

        return $tweetRepository;
    }
}