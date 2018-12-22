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
        //class tweet formatter
        //1. Uppercase
        $text = mb_strtoupper($this->text);

        //2. Remove last point
        $text = mb_ereg_replace('\.$', '', $text);

        //3. Add exclamation mark
        $text = $text . '!';

        return $text;
    }
}
