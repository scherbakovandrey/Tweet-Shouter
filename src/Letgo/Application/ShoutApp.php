<?php

namespace App\Letgo\Application;

use App\Letgo\Domain\ShoutInterface;
use App\Letgo\Domain\TweetFormatter;
use App\Letgo\Domain\TweetsOutput;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use App\Letgo\Infrastructure\FilesystemCachedRepository;
use App\Letgo\Infrastructure\CachedTweetRepository;

use Symfony\Component\HttpFoundation\Response;

class ShoutApp implements ShoutInterface
{
    /**
     * @param TweetRepositoryInMemory $repo
     * @param string $twitterName
     * @param string $limit
     * @return array
     */
    public function shout(TweetRepositoryInMemory $repo, string $twitterName, string $limit): array
    {
        if (!is_numeric($limit) || $limit < 1 || $limit > 10) {
            return [
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'error' => 'Limit parameter MUST be equal or less than 10.',
            ];
        }
        $expiresAfter = $_SERVER['CACHE_EXPIRES_AFTER'];
        $cacheFolder = $_SERVER['CACHE_FOLDER'];

        //$tweetRepository = $repo;
        $tweetRepository = new CachedTweetRepository($repo, (new FilesystemCachedRepository($expiresAfter, $cacheFolder)));

        $tweets = $tweetRepository->searchByUserName($twitterName, $limit);

        if (!count($tweets)) {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Sorry, the requested resource doesn\'t exist.',
            ];
        }

        $formattedTweets = (new TweetsOutput(new TweetFormatter()))->output($tweets);

        return [
            'status' => Response::HTTP_OK,
            'error' => '',
            'tweets' => $formattedTweets
        ];

        return $formattedTweets;
    }
}