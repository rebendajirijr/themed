<?php

namespace JR\Themed\ThemeManager;

use Nette\Object;
use Nette\Utils\AssertionException;
use Nette\Utils\Finder;
use Nette\Utils\Validators;
use JR\Themed\DirectoryNotFoundException;
use JR\Themed\InvalidArgumentException;
use JR\Themed\IThemeManager;

/**
 * Simplest theme manager implementation.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class SimpleThemeManager extends Object implements IThemeManager
{
	/** @var string */
	public static $defaultTheme = 'default';
	
	/** @var string */
	public static $defaultFallbackTheme = 'default';
	
	/** @var string */
	private $currentTheme;
	
	/** @var string */
	private $fallbackTheme;
	
	/** @var string */
	private $themesDir;
	
	public function __construct($themesDir)
	{
		$this->setThemesDir($themesDir);
		$this->setCurrentTheme(static::$defaultTheme);
		$this->setFallbackTheme(static::$defaultFallbackTheme);
	}
	
	/*
	 * @inheritdoc
	 */
	public function setThemesDir($themesDir)
	{
		if (!is_dir($themesDir)) {
			throw new DirectoryNotFoundException("Directory '$themesDir' not found.");
		}
		$this->themesDir = $themesDir;
		return $this;
	}
	
	/*
	 * @inheritdoc
	 */
	public function getThemesDir()
	{
		return $this->themesDir;
	}
	
	/*
	 * @inheritdoc
	 */
	public function setCurrentTheme($theme)
	{
		$this->currentTheme = $this->validateTheme($theme);
		return $this;
	}
	
	/*
	 * @inheritdoc
	 */
	public function getCurrentTheme()
	{
		return $this->currentTheme;
	}
	
	/*
	 * @inheritdoc
	 */
	public function setFallbackTheme($fallbackTheme)
	{
		$this->fallbackTheme = $this->validateTheme($fallbackTheme);
		return $this;
	}
	
	/*
	 * @inheritdoc
	 */
	public function getFallbackTheme()
	{
		return $this->fallbackTheme;
	}
	
	/*
	 * @inheritdoc
	 */
	public function getAvailableThemes()
	{
		$directories = array_keys(
			iterator_to_array(
				Finder::findDirectories('*')->in($this->getThemesDir())
			)
		);
		array_walk($directories, function (&$item, $key) {
			$item = basename($item);
		});
		return $directories;
	}
	
	/**
	 * @param string
	 * @return string
	 * @throws AssertionException If theme is not string value.
	 * @throws InvalidArgumentException If theme name is not valid (not listed in available themes).
	 */
	private function validateTheme($theme)
	{
		Validators::assert($theme, 'string', 'theme');
		if (!in_array($theme, $this->getAvailableThemes(), TRUE)) {
			throw new InvalidArgumentException("Unsupported theme '$theme' given.");
		}
		return $theme;
	}
}
