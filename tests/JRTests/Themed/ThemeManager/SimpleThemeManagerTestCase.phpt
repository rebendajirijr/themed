<?php

namespace JRTests\Themed\ThemeManager;

use Tester\Assert;
use Tester\TestCase;
use JR\Themed\ThemeManager\RuntimeThemeManager;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Description of SimpleThemeManagerTestCase.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class SimpleThemeManagerTestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testDefaultCurrentTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		
		$runtimeThemeManager = new RuntimeThemeManager(
			$themesDir,
			'default',
			'default'
		);
		
		Assert::equal('default', $runtimeThemeManager->getCurrentTheme());
	}
	
	/**
	 * @return void
	 */
	public function testDefaultFallbackTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		
		$runtimeThemeManager = new RuntimeThemeManager(
			$themesDir,
			'default',
			'default'
		);
		
		Assert::equal('default', $runtimeThemeManager->getFallbackTheme());
	}
	
	/**
	 * @return void
	 */
	public function testSetCurrentTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		$currentTheme = 'bootstrap';
		
		$runtimeThemeManager = new RuntimeThemeManager(
			$themesDir,
			'default',
			'default'
		);
		$runtimeThemeManager->setCurrentTheme($currentTheme);
		
		Assert::equal($currentTheme, $runtimeThemeManager->getCurrentTheme());
	}
	
	/**
	 * @return void
	 */
	public function testSetFallbackTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		$fallbackTheme = 'bootstrap';
		
		$runtimeThemeManager = new RuntimeThemeManager(
			$themesDir,
			'default',
			'default'
		);
		$runtimeThemeManager->setFallbackTheme($fallbackTheme);
		
		Assert::equal($fallbackTheme, $runtimeThemeManager->getFallbackTheme());
	}
	
	/**
	 * @return void
	 */
	public function testInvalidThemesDirResultsInDirectoryNotFoundException()
	{
		$themesDir = __DIR__ . '/data/themes-not-found';
		
		Assert::exception(function () use ($themesDir) {
			new RuntimeThemeManager(
				$themesDir,
				'default',
				'default'
			);
		}, 'JR\Themed\DirectoryNotFoundException', "Directory '$themesDir' does not exist or not accessible.");
	}
	
	/**
	 * @return void
	 */
	public function testInvalidThemeNameResultsInInvalidArgumentException()
	{
		$themesDir = __DIR__ . '/data/themes';
		$currentTheme = 'foo';
		
		$runtimeThemeManager = new RuntimeThemeManager(
			$themesDir,
			'default',
			'default'
		);
		
		Assert::exception(function () use ($runtimeThemeManager, $currentTheme) {
			$runtimeThemeManager->setCurrentTheme($currentTheme);
		}, 'JR\Themed\InvalidArgumentException', "Unsupported theme '$currentTheme' given.");
		
	}
	
	/**
	 * @return void
	 */
	public function testInvalidFallbackThemeNameResultsInInvalidArgumentException()
	{
		$themesDir = __DIR__ . '/data/themes';
		$fallbackTheme = 'foo';
		
		$runtimeThemeManager = new RuntimeThemeManager(
			$themesDir,
			'default',
			'default'
		);
		
		Assert::exception(function () use ($runtimeThemeManager, $fallbackTheme) {
			$runtimeThemeManager->setFallbackTheme($fallbackTheme);
		}, 'JR\Themed\InvalidArgumentException', "Unsupported theme '$fallbackTheme' given.");
	}
}

run(new SimpleThemeManagerTestCase());
