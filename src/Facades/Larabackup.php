<?php

namespace Basry\Larabackup\Facades;

use Illuminate\Support\Facades\Facade;
use Basry\Larabackup\Contracts\DatabaseBackup;

class Larabackup extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DatabaseBackup::class;
    }
}
