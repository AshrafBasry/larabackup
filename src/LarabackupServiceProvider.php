<?php

namespace Basry\Larabackup;

use Illuminate\Support\ServiceProvider;

class LarabackupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(Contracts\DatabaseBackup::class, Larabackup::class);
        //
        $this->mergeConfigFrom(__DIR__.'/../config/larabackup.php', 'larabackup');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Larabackup Routes
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            // Publish Config File
            $this->publishes([
                __DIR__.'/../config/larabackup.php' => config_path('larabackup.php'),
            ], 'larabackup-config');

            $this->commands([
                Console\BackupCommand::class,
                Console\RestoreCommand::class,
                Console\ListCommand::class
            ]);
        }
    }
}
