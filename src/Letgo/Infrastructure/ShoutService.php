<?php

namespace App\Letgo\Infrastructure;

use App\Letgo\Domain\Tweet;
use App\Letgo\Domain\ShoutServiceInterface;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
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
                'error' => 'Limit parameter MUST be equal or less than 10',
            ];
        }

        //check valid username ?

        //service???
        $tweets = $repo->searchByUserName($twitterName, $limit);

        //service???
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