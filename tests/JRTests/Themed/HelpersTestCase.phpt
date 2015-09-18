<?php

namespace JRTests\Themed;

use Tester\Assert;
use Tester\TestCase;
use JR\Themed\Helpers;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Description of HelpersTestCase.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class HelpersTestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testConstructThrowsStaticClassException()
	{
		Assert::exception(function() {
			new Helpers();
		}, 'JR\Themed\StaticClassException');
	}
	
	/**
	 * @return void
	 */
	public function testUnifyDirectorySeparators()
	{
		$expected = DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'path';
		Assert::same($expected, Helpers::unifyDirectorySeparators('/var/home\www\test' . DIRECTORY_SEPARATOR . '..\path'));
	}
}

run(new HelpersTestCase());
