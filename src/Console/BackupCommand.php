<?php

namespace Basry\Larabackup\Console;

use Illuminate\Console\Command;
use Basry\Larabackup\Larabackup;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabackup:backup
            {--name= : The Dump File Name }
            {--database= : database connection to use for dump}
            {--disk= : disk to use for dump}
            {--path= : path to use for dump}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump Database';

    /**
     * Execute the console command.
     *
     * @param  \Basry\Larabackup\Larabackup  $larabackup
     * @return void
     */
    public function handle(Larabackup $larabackup)
    {
        $name = $this->option('name') ?: null;
        if ($database = $this->option('database')) {
            $larabackup->connection($database);
        }
        if ($disk = $this->option('disk')) {
            $larabackup->disk($disk);
        }
        if ($path = $this->option('path')) {
            $larabackup->path($path);
        }
        $backupName = $larabackup->backup($name);

        $this->info('Backup Created Successfully');
        
        $this->line('<comment>Backup Name:</comment> ' . $backupName);
        $this->line('<comment>Backup Path:</comment> ' . $larabackup->realPath());
    }
}
