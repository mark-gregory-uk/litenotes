<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

final class ArchivableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->configureMacros();
    }

    /**
     * Configure the macros to be used.
     */
    protected function configureMacros(): void
    {
        Blueprint::macro('archivedAt', fn ($column = 'archived_at', $precision = 0) => $this->timestamp($column, $precision)->nullable());
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
    }
}
