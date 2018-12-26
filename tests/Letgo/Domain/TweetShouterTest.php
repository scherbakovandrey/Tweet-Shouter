<?php

namespace App\Tests\Letgo\Domain;

use PHPUnit\Framework\TestCase;
use App\Letgo\Domain\TweetShouter;
use App\Letgo\Domain\TweetFormatter;
use App\Letgo\Domain\Tweet;

class TweetShouterTest extends TestCase
{
    public function testShout()
    {
        $tweets = [
            new Tweet('Test tweet 1.'),
            new Tweet('Test tweet 2.'),
            new Tweet('Test tweet 3.')
        ];

        $shoutedTweets = (new TweetShouter(new TweetFormatter()))->shout($tweets);
        $this->assertEquals($shoutedTweets, [
            'TEST TWEET 1!',
            'TEST TWEET 2!',
            'TEST TWEET 3!',
        ]);
    }
}
