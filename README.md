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
## Usage

#### Backup
```
Larabackup::backup(); // Auto Naming
```
Or
```
Larabackup::backup('Dump Name');
```

#### Restore
```
Larabackup::restore($dumpName);
```
## License

Larabackup is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).