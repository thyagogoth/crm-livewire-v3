<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    public function givePermissionTo(string $key): void
    {
        $this->permissions()->firstOrCreate(['key' => $key]);

        $cacheKey = $this->getPermissionCacheKey();
        Cache::forget($cacheKey);
        Cache::rememberForever(
            $cacheKey,
            fn () => $this->permissions
        );
    }

    public function hasPermissionTo(string $key): bool
    {

        /** @var Collection|mixed $permissions */
        $permissions = Cache::get($this->getPermissionCacheKey(), $this->permissions);

        return $permissions
            ->where(['key' => $key])
            ->isNotEmpty();
    }

    /**
     * @return string
     */
    private function getPermissionCacheKey(): string
    {
        return "user::{$this->id}::permissions";
    }

}
