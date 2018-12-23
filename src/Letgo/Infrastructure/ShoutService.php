<?php

namespace App\Letgo\Infrastructure;

use App\Letgo\Domain\ShoutServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class ShoutService implements ShoutServiceInterface
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

        $tweetRepository = $repo;
        //$tweetRepository = new CachedTweetRepository($repo, new FilesystemCachedRepository($expiresAfter));

        $tweets = $tweetRepository->searchByUserName($twitterName, $limit);

        //What if username is not valid or doesn't exit? We may return empty $tweets array
        if (!count($tweets)) {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Sorry, the requested resource doesn\'t exist.',
            ];
        }

        $formattedTweets = [];
        foreach ($tweets as $tweet) {
            $formattedTweets[] = $tweet->getText();
        }

        return [
            'status' => Response::HTTP_OK,
            'error' => '',
            'tweets' => $formattedTweets
        ];

        return $formattedTweets;
    }
}