<?php

namespace App\Letgo\Domain;

use App\Letgo\Domain\TweetFormatterServiceInterface;

class TweetsOutput implements TweetOutputInterface
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
    public function output(array $tweets): array
    {
        $formattedTweets = [];
        foreach ($tweets as $tweet) {
            $formattedTweets[] = $this->formatter->format($tweet->getText());
        }
        return $formattedTweets;
    }
}