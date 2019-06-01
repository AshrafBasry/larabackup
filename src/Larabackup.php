<?php

namespace Basry\Larabackup;

use Basry\Larabackup\Contracts\DatabaseBackup;
use Ifsnop\Mysqldump\Mysqldump;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Basry\Larabackup\Exceptions\FileNotFoundException;

class Larabackup implements DatabaseBackup
{
	/**
	 * Databse Connection
	 * @var string
	 */
	protected $connection;

	/**
	 * Database Connection Config
	 * @var array
	 */
	protected $config;

	/**
	 * Backup Storage Disk
	 * @var string
	 */
	protected $disk;

	/**
	 * Backup Storage Path 
	 * @var string
	 */
	protected $path;

	/**
	 * Storage Instance
	 * @var [type]
	 */
	protected $storage;

	/**
	 * Create New Larabackup Instance
	 * @param string $connection [Database Connection]
	 */
	public function __construct()
	{
		$this->connection(config('database.default'));
		$this->disk(config('larabackup.disk'));
		$this->path(config('larabackup.path'));
	}

	/**
	 * Make Database Backup
	 * 
	 * @param  string $backupName
	 * @return string Generated Backup File Name
	 */
	public function backup($backupName = null)
	{
		if (!$backupName) {
			$backupName = $this->connection;
		}
		$path = $this->getPath();
		if(!$this->storage->exists($path)) {
            $this->storage->makeDirectory($path, 0777, true);
        }
        $backupFileName = time() . '-' . $backupName . '.sql';
        $dump = new Mysqldump('mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['database'], $this->config['username'], $this->config['password']);
        $dump->start($this->realPath() . '/' . $backupFileName);
        return $backupFileName;
	}

	/**
	 * Restore Backup File
	 * 
	 * @param  string $backupName
	 * @return bool
	 */
	public function restore($backupName)
	{
		$fullPath = $this->getPath() . '/' . $backupName . '.sql';
		if (!$this->storage->exists($fullPath)) {
			throw new FileNotFoundException($this->storage->path($fullPath));
		}
		$this->dropDatabase();
        $sql = $this->storage->get($fullPath);
        return DB::connection($this->connection)->unprepared($sql);
	}

	/**
	 * Delete Database Backup File
	 * 
	 * @param  string $backupName
	 * @return boolean
	 */
	public function delete($backupName)
	{
		return $this->storage->delete($this->getPath() . '/' . $backupName . '.sql');
	}

	/**
	 * Download Database Backup File
	 * 
	 * @param  string $backupName
	 * @return response
	 */
	public function download($backupName)
	{
		return $this->storage->download($this->getPath() . '/' . $backupName . '.sql');
	}

	/**
	 * List Database Dump Files
	 * 
	 * @return array
	 */
	public function listDumps()
	{
		$files = $this->storage->files($this->getPath());
        $dumps = [];
        foreach ($files as $file) {
            $file = basename($file, '.sql');
            $exp = explode('-', $file);
            $dumps[] = [
                'id'   => $file,
                'name' => $exp[1],
                'date' => date('Y-m-d', $exp[0]),
                'time' => date('H:i:s', $exp[0]),
            ];
        }
        return $dumps;
	}

	/**
	 * Set Database Backups Disk
	 * 
	 * @param  string $disk
	 * @return this instance
	 */
	public function disk($disk)
	{
		$this->disk = $disk;
		$this->storage = Storage::disk($disk);
		return $this;
	}

	/**
	 * Set Database Backups Path
	 * 
	 * @param  string $path
	 * @return this instance
	 */
	public function path($path)
	{
		$this->path = $path;
		return $this;
	}

	/**
	 * Set Database Connection
	 * 
	 * @param  string $connection [description]
	 * @return this instance
	 */
	public function connection($connection)
	{
		$this->connection = $connection;
		$this->config = config('database.connections.' . $connection);
		return $this;
	}

	public function realPath()
	{
        return $this->storage->path($this->getPath());
	}

	/**
	 * Drop Database
	 * 
	 * @return boolean
	 */
	private function dropDatabase()
	{
		$colname = 'Tables_in_' . $this->config['database'];
		$db = DB::connection($this->connection);
        $tables = $db->select('SHOW TABLES');

        foreach($tables as $table) {

            $droplist[] = $table->$colname;

        }
        $droplist = implode(',', $droplist);

        $db->beginTransaction();
        //turn off referential integrity
        $db->statement('SET FOREIGN_KEY_CHECKS = 0');
        $db->statement("DROP TABLE $droplist");
        //turn referential integrity back on
        $db->statement('SET FOREIGN_KEY_CHECKS = 1');
        return $db->commit();
	}

	/**
	 * Get Path To Storage
	 * 
	 * @return string
	 */
	private function getPath()
	{
		return $this->path . '/' . $this->connection;
	}
}