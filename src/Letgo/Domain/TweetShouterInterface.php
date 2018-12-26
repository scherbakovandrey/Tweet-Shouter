<?php

namespace App\Letgo\Domain;

interface TweetShouterInterface
{
    /**
     * @param Tweet[] $tweets
     * @return array
     */
    public function shout(array $tweets): array;
}