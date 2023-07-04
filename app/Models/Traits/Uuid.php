<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid as PackageUuid;

/**
 * A Proper way to handle UUID creation and not have controller
 * or seeder do this, they are created as the row is written.
 */
trait Uuid
{
    final public function scopeUuid($query, string $uuid): mixed
    {
        return $query->where($this->getUuidName(), $uuid);
    }

    final public function getUuidName(): string
    {
        return property_exists($this, 'uuidName') ? $this->uuidName : 'uuid';
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getUuidName()} = PackageUuid::uuid4()->toString();
        });
    }
}
