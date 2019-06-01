<h1 align="center">Larabackup</h1>
<p align="center">Simple Laravel Database Backup Solution</p>
<p align="center">
	<a href="https://packagist.org/packages/basry/larabackup">
		<img src="https://poser.pugx.org/basry/larabackup/v/stable" alt="Latest Stable Version">
	</a>
	<a href="https://packagist.org/packages/basry/larabackup">
		<img src="https://poser.pugx.org/basry/larabackup/downloads" alt="Total Downloads">
	</a>
	<a href="https://packagist.org/packages/basry/larabackup">
		<img src="https://poser.pugx.org/basry/larabackup/v/unstable" alt="Latest Unstable Version">
	</a>
	<a href="https://packagist.org/packages/basry/larabackup">
		<img src="https://poser.pugx.org/basry/larabackup/license" alt="License">
	</a>
</p>


## Installation

```
composer require basry/larabackup
```
### For Laravel < 5.5
After updating composer, add the ServiceProvider to the providers array in config/app.php
````
Basry\Larabackup\LarabackupServiceProvider::class,
````

## Usage
Using Facade
```
use Basry\Larabackup\Facades\Larabackup;
```
#### Backup
```
Larabackup::backup(); // Auto Naming
```
Or
```
Larabackup::backup($dumpName);
```

#### Restore
```
Larabackup::restore($dumpFullName);
```

### Artisan
You can backup, restore, and list database dumps using cli.
#### Backup
```
php artisan larabackup:backup
```
#### Restore
```
php artisan larabackup:restore dumpFullName
```
#### List Dumps
```
php artisan larabackup:list
```
## Config
You can publish config files if you need to change the defaults
```
php artisan vendor:publish --tag=larabackup-config
```
### Default Configuration
```
'disk' => 'local',  // Storage Disk To use
'path' => 'database/dumps', // Path To save and restore dumps
```
### Override Default Configuration
You can override any of the default configs
#### Database Connection
```
Larabackup::connection($connection)->backup();
```
```
php artisan larabackup:backup --database=DatabaseName
```
#### Storage Disk
```
Larabackup::disk($disk)->restore($backupName);
```
```
php artisan larabackup:backup --disk=Disk
```
#### Storage Path
```
Larabackup::path($path)->backup();
```
```
php artisan larabackup:backup --path=Path
```
## License

Larabackup is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).