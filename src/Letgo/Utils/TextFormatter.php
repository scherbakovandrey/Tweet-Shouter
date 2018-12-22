<?php

namespace App\Letgo\Utils;

final class TextFormatter
{
    public static function format(string $text): string
    {
        $text = mb_ereg_replace('[\.!]$', '', $text);

        if (empty($text))
            return '';

        $text = $text . '!';
        $text = mb_strtoupper($text);

        return $text;
    }
}
