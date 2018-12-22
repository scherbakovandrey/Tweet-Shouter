<?php

namespace App\Letgo\Domain;

interface TweetServiceInterface
{
    /**
     * @param Tweet[] $tweets
     * @return array
     */
    public function format($tweets): array;
}
