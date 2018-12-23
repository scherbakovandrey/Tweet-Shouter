<?php

namespace App\Letgo\Infrastructure;

use App\Letgo\Domain\Tweet;
use App\Letgo\Domain\TweetRepository;

final class CachedTweetRepository implements TweetRepository
{
    static $maxHits = 2;

    static $hitsCounter = [];

    /**
     * @var TweetRepository
     */
    private $repo;

    /**
     * @var CachedRepositoryInterface
     */
    private $cachedRepository;

    public function __construct(TweetRepository $repo, CachedRepositoryInterface $cachedRepository)
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
        $tweets = [];

        if (!isset(self::$hitsCounter[$username])) {
            self::$hitsCounter[$username] = 0;
        }

        //check if we hit cache less then $maxHits times
        if (self::$hitsCounter[$username] < self::$maxHits) {
            //check if we have information in cache
            $tweets = $this->cachedRepository->get('tweets.' . $username);

            //check if we have enough items (or we don't have any) based on current limit requested, otherwise we need to hit API and update the cache
            if (count($tweets) >= $limit) {
                //get just $limit first items from cache
                $tweets = array_slice($tweets, 0, $limit);

                //increment hits counter
                self::$hitsCounter[$username]++;
            } else {
                $tweets = [];
            }
        }  else {
            //clear the cache
            $this->cachedRepository->clear();

            //reset the hits counter
            self::$hitsCounter[$username] = 0;
        }

        //if we don't find anything in cache we hit API
        if (!count($tweets)) {
            $tweets = $this->repo->searchByUserName($username, $limit);

            //save items to cache
            $this->cachedRepository->save('tweets.' . $username, $tweets);
        }
        return $tweets;
    }

    public function hasItem($username): bool
    {
        return $this->cachedRepository->hasItem('tweets.' . $username);
    }
}