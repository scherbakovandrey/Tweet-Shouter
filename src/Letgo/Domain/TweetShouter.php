<?php

namespace App\Letgo\Domain;

use App\Letgo\Domain\TweetFormatterServiceInterface;

class TweetShouter implements TweetShouterInterface
{
    /**
     * @var FormatInterface
     */
    private $formatter;

    public function __construct(FormatInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @param Tweet[] $tweets
     * @return array
     */
    public function shout(array $tweets): array
    {
        $shoutedTweets = [];
        foreach ($tweets as $tweet) {
            $shoutedTweets[] = $this->formatter->format($tweet->getText());
        }
        return $shoutedTweets;
    }
}