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
	public function testDefaultTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		
		$simpleThemeManager = new RuntimeThemeManager($themesDir);
		
		Assert::equal(RuntimeThemeManager::$defaultTheme, $simpleThemeManager->getCurrentTheme());
	}
	
	/**
	 * @return void
	 */
	public function testDefaultFallbackTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		
		$simpleThemeManager = new RuntimeThemeManager($themesDir);
		
		Assert::equal(RuntimeThemeManager::$defaultFallbackTheme, $simpleThemeManager->getFallbackTheme());
	}
	
	/**
	 * @return void
	 */
	public function testSetCurrentTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		$currentTheme = 'bootstrap';
		
		$simpleThemeManager = new RuntimeThemeManager($themesDir);
		$simpleThemeManager->setCurrentTheme($currentTheme);
		
		Assert::equal($currentTheme, $simpleThemeManager->getCurrentTheme());
	}
	
	/**
	 * @return void
	 */
	public function testSetFallbackTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		$fallbackTheme = 'bootstrap';
		
		$simpleThemeManager = new RuntimeThemeManager($themesDir);
		$simpleThemeManager->setFallbackTheme($fallbackTheme);
		
		Assert::equal($fallbackTheme, $simpleThemeManager->getFallbackTheme());
	}
	
	/**
	 * @return void
	 */
	public function testInvalidThemesDirResultsInDirectoryNotFoundException()
	{
		$themesDir = __DIR__ . '/data/themes-not-found';
		
		Assert::exception(function () use ($themesDir) {
			$simpleThemeManager = new RuntimeThemeManager($themesDir);
		}, 'JR\Themed\DirectoryNotFoundException', "Directory '$themesDir' does not exist or not accessible.");
	}
	
	/**
	 * @return void
	 */
	public function testInvalidThemeNameResultsInInvalidArgumentException()
	{
		$themesDir = __DIR__ . '/data/themes';
		$theme = 'foo';
		
		$simpleThemeManager = new RuntimeThemeManager($themesDir);
		
		Assert::exception(function () use ($simpleThemeManager, $theme) {
			$simpleThemeManager->setCurrentTheme($theme);
		}, 'JR\Themed\InvalidArgumentException', "Unsupported theme '$theme' given.");
		
	}
	
	/**
	 * @return void
	 */
	public function testInvalidFallbackThemeNameResultsInInvalidArgumentException()
	{
		$themesDir = __DIR__ . '/data/themes';
		$theme = 'foo';
		
		$simpleThemeManager = new RuntimeThemeManager($themesDir);
		
		Assert::exception(function () use ($simpleThemeManager, $theme) {
			$simpleThemeManager->setFallbackTheme($theme);
		}, 'JR\Themed\InvalidArgumentException', "Unsupported theme '$theme' given.");
	}
}

run(new SimpleThemeManagerTestCase());
