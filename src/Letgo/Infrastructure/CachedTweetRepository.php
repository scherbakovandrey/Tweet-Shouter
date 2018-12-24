<?php

namespace App\Letgo\Infrastructure;

use App\Letgo\Domain\Tweet;
use App\Letgo\Domain\TweetRepositoryInterface;

final class CachedTweetRepository implements TweetRepositoryInterface
{
    private static $cacheNamespace = 'tweets.';

    /**
     * @var TweetRepositoryInterface
     */
    private $repo;

    /**
     * @var CachedRepositoryInterface
     */
    private $cachedRepository;

    public function __construct(TweetRepositoryInterface $repo, CachedRepositoryInterface $cachedRepository)
    {
        $this->repo = $repo;
        $this->cachedRepository = $cachedRepository;
    }

    /**
     * @param string $username
     * @param int $limit
     * @return Tweet[]
     */
    public function searchByUserName(string $username, int $limit): array
    {
        $tweets = $this->getTweetsFromCacheRepository($username, $limit);

        //if there are no tweets in cache or there are not enough tweets - we hit API and save items to cache
        if (!count($tweets)) {
            $tweets = $this->repo->searchByUserName($username, $limit);
            $this->save($username, $tweets);
        }
        return $tweets;
    }

    private function getTweetsFromCacheRepository(string $username, int $limit) : array
    {
        $tweets = $this->cachedRepository->get(self::$cacheNamespace . $username);

        //check if we have enough items (or we don't have any) based on current limit requested, otherwise we need to hit API and update the cache
        if (count($tweets) >= $limit) {
            //get just $limit first items from cache
            $tweets = array_slice($tweets, 0, $limit);
        } else {
            //we don't have enough tweets in cache so we need to get it from API
            $tweets = [];
        }
        return $tweets;
    }

    private function save($username, $tweets)
    {
        $this->cachedRepository->save(self::$cacheNamespace . $username, $tweets);
    }
}