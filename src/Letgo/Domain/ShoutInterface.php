<?php

namespace App\Letgo\Domain;

use App\Letgo\Infrastructure\TweetRepositoryInMemory;

interface ShoutInterface
{
    /**
     * @param TweetRepositoryInMemory $repo
     * @param string $twitterName
     * @param string $limit
     * @return array
     */
    public function shout(TweetRepositoryInMemory $repo, string $twitterName, string $limit): array;
}
