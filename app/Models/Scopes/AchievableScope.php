<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AchievableScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Archive', 'UnArchive', 'WithArchived', 'WithoutArchived', 'OnlyArchived'];

    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (is_callable([$model, 'getQualifiedArchivedAtColumn'], true, $name)) {
            $builder->whereNull($model->getQualifiedArchivedAtColumn());
        }
    }

    /**
     * Extend the query builder with the needed functions.
     */
    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Get the "archived at" column for the builder.
     *
     * @return string
     */
    protected function getArchivedAtColumn(Builder $builder)
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedArchivedAtColumn();
        }

        return $builder->getModel()->getArchivedAtColumn();
    }

    /**
     * Add the archive extension to the builder.
     */
    protected function addArchive(Builder $builder): void
    {
        $builder->macro('archive', function (Builder $builder) {
            $column = $this->getArchivedAtColumn($builder);

            return $builder->update([
                $column => $builder->getModel()->freshTimestampString(),
            ]);
        });
    }

    /**
     * Add the un-archive extension to the builder.
     */
    protected function addUnArchive(Builder $builder): void
    {
        $builder->macro('unArchive', function (Builder $builder) {
            $builder->withArchived();

            $column = $this->getArchivedAtColumn($builder);

            return $builder->update([
                $column => null,
            ]);
        });
    }

    /**
     * Add the with-archive extension to the builder.
     */
    protected function addWithArchived(Builder $builder): void
    {
        $builder->macro('withArchived', function (Builder $builder, $withArchived = true) {
            if (! $withArchived) {
                return $builder->withoutArchived();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-archive extension to the builder.
     */
    protected function addWithoutArchived(Builder $builder): void
    {
        $builder->macro('withoutArchived', function (Builder $builder) {
            $model = $builder->getModel();

            return $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedArchivedAtColumn()
            );
        });
    }

    /**
     * Add the only-archive extension to the builder.
     */
    protected function addOnlyArchived(Builder $builder): void
    {
        $builder->macro('onlyArchived', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedArchivedAtColumn()
            );

            return $builder;
        });
    }
}
