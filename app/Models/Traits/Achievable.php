<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Scopes\AchievableScope;
use Closure;
use Exception;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder withArchived()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder onlyArchived()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder withoutArchived()
 */
trait Achievable
{
    /**
     * Indicates if the model should use archives.
     */
    public bool $archives = true;

    /**
     * Boot the archiving trait for a model.
     */
    public static function bootAchievable(): void
    {
        static::addGlobalScope(new AchievableScope());
    }

    /**
     * Initialize the soft deleting trait for an instance.
     */
    public function initializeAchievable(): void
    {
        if (! isset($this->casts[$this->getArchivedAtColumn()])) {
            $this->casts[$this->getArchivedAtColumn()] = 'datetime';
        }
    }

    /**
     * Archive the model.
     *
     * @return bool|null
     *
     * @throws Exception
     */
    final public function archive()
    {
        $this->mergeAttributesFromClassCasts();

        if (null === $this->getKeyName()) {
            throw new Exception('No primary key defined on model.');
        }

        // If the model doesn't exist, there is nothing to archive.
        if (! $this->exists) {
            return;
        }

        // If the archiving event doesn't return false, we'll continue
        // with the operation.
        if (false === $this->fireModelEvent('archiving')) {
            return false;
        }

        // Update the timestamps for each of the models owners. Breaking any caching
        // on the parents
        $this->touchOwners();

        $this->runArchive();

        // Fire archived event to allow hooking into the post-archive operations.
        $this->fireModelEvent('archived', false);

        // Return true as the archive is presumably successful.
        return true;
    }

    /**
     * Perform the actual archive query on this model instance.
     */
    final public function runArchive(): void
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $time = $this->freshTimestamp();

        $columns = [$this->getArchivedAtColumn() => $this->fromDateTime($time)];

        $this->{$this->getArchivedAtColumn()} = $time;

        if ($this->usesTimestamps() && null !== $this->getUpdatedAtColumn()) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        $query->update($columns);

        $this->syncOriginalAttributes(array_keys($columns));
    }

    final public function unArchive()
    {
        // If the archiving event return false, we will exit the operation.
        // Otherwise, we will clear the archived at timestamp and continue
        // with the operation
        if (false === $this->fireModelEvent('unArchiving')) {
            return false;
        }

        $this->{$this->getArchivedAtColumn()} = null;

        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('unArchived', false);

        return $result;
    }

    /**
     * Determine if the model instance has been archived.
     */
    final public function isArchived(): bool
    {
        return null !== $this->{$this->getArchivedAtColumn()};
    }

    final public function isNotArchived(): bool
    {
        return null == $this->{$this->getArchivedAtColumn()};
    }

    /**
     * Register a "archiving" model event callback with the dispatcher.
     *
     * @param  Closure|string  $callback
     */
    public static function archiving($callback): void
    {
        static::registerModelEvent('archiving', $callback);
    }

    /**
     * Register a "archived" model event callback with the dispatcher.
     *
     * @param  Closure|string  $callback
     */
    public static function archived($callback): void
    {
        static::registerModelEvent('archived', $callback);
    }

    /**
     * Register a "un-archiving" model event callback with the dispatcher.
     *
     * @param  Closure|string  $callback
     */
    public static function unArchiving($callback): void
    {
        static::registerModelEvent('unArchiving', $callback);
    }

    /**
     * Register a "un-archived" model event callback with the dispatcher.
     *
     * @param  Closure|string  $callback
     */
    public static function unArchived($callback): void
    {
        static::registerModelEvent('unArchived', $callback);
    }

    /**
     * Get the name of the "created at" column.
     *
     * @return string
     */
    public function getArchivedAtColumn()
    {
        return defined('static::ARCHIVED_AT') ? static::ARCHIVED_AT : 'archived_at';
    }

    /**
     * Get the fully qualified "created at" column.
     *
     * @return string
     */
    final public function getQualifiedArchivedAtColumn()
    {
        return $this->qualifyColumn($this->getArchivedAtColumn());
    }
}
