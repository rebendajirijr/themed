<?php

namespace JRTests\Themed\ThemeManager;

use Tester\Assert;
use Tester\TestCase;
use JR\Themed\ThemeManager\SimpleThemeManager;

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
		
		$simpleThemeManager = new SimpleThemeManager($themesDir);
		
		Assert::equal(SimpleThemeManager::$defaultTheme, $simpleThemeManager->getCurrentTheme());
	}
	
	/**
	 * @return void
	 */
	public function testDefaultFallbackTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		
		$simpleThemeManager = new SimpleThemeManager($themesDir);
		
		Assert::equal(SimpleThemeManager::$defaultFallbackTheme, $simpleThemeManager->getFallbackTheme());
	}
	
	/**
	 * @return void
	 */
	public function testSetCurrentTheme()
	{
		$themesDir = __DIR__ . '/data/themes';
		$currentTheme = 'bootstrap';
		
		$simpleThemeManager = new SimpleThemeManager($themesDir);
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
		
		$simpleThemeManager = new SimpleThemeManager($themesDir);
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
			$simpleThemeManager = new SimpleThemeManager($themesDir);
		}, 'JR\Themed\DirectoryNotFoundException', "Directory '$themesDir' not found.");
	}
	
	/**
	 * @return void
	 */
	public function testInvalidThemeNameResultsInInvalidArgumentException()
	{
		$themesDir = __DIR__ . '/data/themes';
		$theme = 'foo';
		
		$simpleThemeManager = new SimpleThemeManager($themesDir);
		
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
		
		$simpleThemeManager = new SimpleThemeManager($themesDir);
		
		Assert::exception(function () use ($simpleThemeManager, $theme) {
			$simpleThemeManager->setFallbackTheme($theme);
		}, 'JR\Themed\InvalidArgumentException', "Unsupported theme '$theme' given.");
	}
}

run(new SimpleThemeManagerTestCase());
