<?php

namespace Modules\Admin\Services;

use Illuminate\Cache\CacheManager;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

/**
 * @mixin TaggedCache
 * @package Modules\Admin\Services
 */
class SystemCommonCacheService
{
    /**
     * @var TaggedCache
     */
    protected $cache;

    public function __call($method, $args)
    {
        $this->cache ??= app('cache')->tags('admin_system_common');
        return $this->cache->{$method}(...$args);
    }
}
