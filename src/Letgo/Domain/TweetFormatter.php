<?php

namespace App\Letgo\Domain;

final class TweetFormatter implements FormatInterface
{
    public function format(string $text): string
    {
        $text = mb_ereg_replace('[\.!]$', '', $text);

        if (empty($text))
            return '';

        $text = $text . '!';
        $text = mb_strtoupper($text);

        return $text;
    }
}
