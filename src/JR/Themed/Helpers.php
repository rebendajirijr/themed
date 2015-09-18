<?php

namespace JR\Themed;

use Nette\Object;

/**
 * Utility class with some helpers.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class Helpers extends Object
{
	/**
	 * @throws StaticClassException
	 */
	public function __construct()
	{
		throw new StaticClassException();
	}
	
	/**
	 * @param string
	 * @return string
	 */
	public static function unifyDirectorySeparators($path)
	{
		return str_replace(
			'\\',
			DIRECTORY_SEPARATOR,
			str_replace(
				'/',
				DIRECTORY_SEPARATOR,
				$path
			)
		);
	}
}
