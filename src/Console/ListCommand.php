<?php

namespace Basry\Larabackup\Console;

use Illuminate\Console\Command;
use Basry\Larabackup\Larabackup;

class ListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabackup:list
            {--database= : database connection to use for dump}
            {--disk= : disk to use for dump}
            {--path= : path to use for dump}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Exists Database Dumps';

    /**
     * Execute the console command.
     *
     * @param  \Basry\Larabackup\Larabackup  $larabackup
     * @return void
     */
    public function handle(Larabackup $larabackup)
    {
        if ($database = $this->option('database')) {
            $larabackup->connection($database);
        }

        if ($disk = $this->option('disk')) {
            $larabackup->disk($disk);
        }

        if ($path = $this->option('path')) {
            $larabackup->path($path);
        }

        $dumps = $larabackup->listDumps();

        if (count($dumps) > 0) {
            $header = ['ID', 'Name', 'Date', 'Time'];
            $this->table($header, $dumps);
            return;
        }

        $this->error(PHP_EOL . 'NO Dumps Found' . PHP_EOL);
    }
}
