<?php

namespace App\Letgo\Application;

use App\Letgo\Domain\ShoutInterface;
use App\Letgo\Domain\TweetFormatter;
use App\Letgo\Domain\TweetShouter;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use App\Letgo\Infrastructure\TweetRepositoryStaticFactory;
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

        $tweetRepository = TweetRepositoryStaticFactory::createRepository($repo);

        $tweets = $tweetRepository->searchByUserName($twitterName, $limit);

        if (!count($tweets)) {
            return [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Sorry, the requested resource doesn\'t exist.',
            ];
        }

        $shoutedTweets = (new TweetShouter(new TweetFormatter()))->shout($tweets);

        return [
            'status' => Response::HTTP_OK,
            'error' => '',
            'tweets' => $shoutedTweets
        ];
    }
}