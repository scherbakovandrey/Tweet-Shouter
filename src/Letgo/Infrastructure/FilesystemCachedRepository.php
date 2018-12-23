<?php

namespace App\Letgo\Infrastructure;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

final class FilesystemCachedRepository implements CachedRepositoryInterface
{
    /**
     * @var FilesystemAdapter
     */
    private $cachePool;

    private $expiresAfter;

    public function __construct(int $expiresAfter = 30)
    {
        // init cache pool of file system adapter
        $this->cachePool = new FilesystemAdapter('', 0, 'cache');

        if (!empty($expiresAfter))
            $this->expiresAfter = $expiresAfter;

        $this->clear();
    }

    public function setExpiresAfter(int $expiresAfter) {
        $this->expiresAfter = $expiresAfter;
    }

    public function save(string $key, array $items) : void {
        $cachedItems = $this->cachePool->getItem($key);
        if (!$cachedItems->isHit()) {
            $cachedItems->set($items);
            $cachedItems->expiresAfter($this->expiresAfter);
            $this->cachePool->save($cachedItems);
        }
    }

    public function get(string $key) : array {
        if ($this->cachePool->hasItem($key)) {
            $cachedItems = $this->cachePool->getItem($key);
            return $cachedItems->get();
        }
        return [];
    }

    public function clear() : void {
        $this->cachePool->clear();
    }

    public function hasItem(string $key): bool
    {
        return $this->cachePool->hasItem($key);
    }
}