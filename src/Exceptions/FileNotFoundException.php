<?php

namespace Basry\Larabackup\Exceptions;

use Exception;

class FileNotFoundException extends Exception
{
	public function __construct(string $path)
	{
		parent::__construct(sprintf('File %s Doesn\'t Exists.', $path));
	}
}