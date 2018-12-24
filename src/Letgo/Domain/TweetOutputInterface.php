<?php

namespace App\Letgo\Domain;

interface TweetOutputInterface
{
    /**
     * @param Tweet[] $tweets
     * @return array
     */
    public function output(array $tweets): array;
}