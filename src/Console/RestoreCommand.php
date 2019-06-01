<?php

namespace Basry\Larabackup\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Basry\Larabackup\Larabackup;
use Basry\Larabackup\Exceptions\FileNotFoundException;

class RestoreCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabackup:restore
            {id : the id of dump file to restore }
            {--database= : database connection to use for restore}
            {--disk= : disk to restore from}
            {--path= : path to restore from}
            {--force : force restore in production mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore Database';

    /**
     * Execute the console command.
     *
     * @param  \Basry\Larabackup\Larabackup  $larabackup
     * @return void
     */
    public function handle(Larabackup $larabackup)
    {
        $id = $this->argument('id');

        if (! $this->confirmToProceed()) {
            return;
        }

        if ($database = $this->option('database')) {
            $larabackup->connection($database);
        }

        if ($disk = $this->option('disk')) {
            $larabackup->disk($disk);
        }

        if ($path = $this->option('path')) {
            $larabackup->path($path);
        }
        
        try {
            $larabackup->restore($id);
        } catch (\Exception $e) {
            $this->error(PHP_EOL . $e->getMessage() . PHP_EOL);
            return;
        }

        $this->info('Backup Restored Successfully');

        $this->line('<comment>Backup Name:</comment> ' . $id . '.sql');
        $this->line('<comment>Backup Path:</comment> ' . $larabackup->realPath());
    }
}
