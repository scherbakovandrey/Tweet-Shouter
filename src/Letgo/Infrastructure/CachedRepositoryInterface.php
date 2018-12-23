<?php

namespace App\Letgo\Infrastructure;

interface CachedRepositoryInterface
{
    public function setExpiresAfter(int $expiresAfter);

    public function save(string $key, array $items) : void;

    public function get(string $key) : array;

    public function clear() : void;

    public function hasItem(string $key) : bool;
}