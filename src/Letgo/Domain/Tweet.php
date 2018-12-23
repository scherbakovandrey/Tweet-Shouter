<?php

namespace App\Letgo\Domain;

final class Tweet
{
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return TweetFormatter::format($this->text);
    }
}