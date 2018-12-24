<?php

namespace App\Letgo\Domain;

interface FormatInterface
{
    /**
     * @param string $text
     * @return string
     */
    public function format(string $text): string;
}