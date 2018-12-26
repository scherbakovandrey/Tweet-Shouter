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

    public function __construct(string $namespace = '', int $expiresAfter = 30, $cacheFolder = 'cache')
    {
        $this->cachePool = new FilesystemAdapter($namespace, 0, $cacheFolder);
        $this->expiresAfter = $expiresAfter;
    }

    public function setExpiresAfter(int $expiresAfter): FilesystemCachedRepository
    {
        $this->expiresAfter = $expiresAfter;
        return $this;
    }

    public function save(string $key, array $items): void
    {
        $cachedItems = $this->cachePool->getItem($key);
        $cachedItems->set($items);
        $cachedItems->expiresAfter($this->expiresAfter);
        $this->cachePool->save($cachedItems);
    }

    public function get(string $key): array
    {
        if ($this->cachePool->hasItem($key)) {
            $cachedItems = $this->cachePool->getItem($key);
            return $cachedItems->get();
        }
        return [];
    }

    public function clear(): void
    {
        $this->cachePool->clear();
    }

    public function hasItem(string $key): bool
    {
        return $this->cachePool->hasItem($key);
    }
}