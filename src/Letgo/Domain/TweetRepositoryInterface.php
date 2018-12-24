<?php

namespace App\Letgo\Domain;

interface TweetRepositoryInterface
{
    public function searchByUserName(string $username, int $limit): array;
}
