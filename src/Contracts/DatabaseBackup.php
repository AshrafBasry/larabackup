<?php

namespace Basry\Larabackup\Contracts;

interface DatabaseBackup
{
	/**
	 * Make Database Backup
	 * 
	 * @param  string $backupName
	 * @return bool  
	 */
	public function backup($backupName = null);

	/**
	 * Restore Backup File
	 * 
	 * @param  string $backupName [description]
	 * @return bool
	 */
	public function restore($backupName);
}