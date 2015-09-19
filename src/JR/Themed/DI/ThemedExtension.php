<?php

namespace JR\Themed\DI;

use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;
use JR\Themed\DirectoryNotFoundException;
use JR\Themed\ThemeManager\RuntimeThemeManager;

/**
 * Nette Framework DI extension with theme related stuff.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class ThemedExtension extends CompilerExtension
{
	/** @var string */
	const DEFAULT_CURRENT_THEME = 'default';
	
	/** @var string */
	const DEFAULT_FALLBACK_THEME = 'default';
	
	/** @var array */
	public $defaults = [
		'themesDir' => NULL,
		'currentTheme' => NULL,
		'fallbackTheme' => NULL,
	];
	
	public function __construct()
	{
		$this->defaults['themesDir'] = __DIR__ . '/../../../../../../../../resources/themes';
		$this->defaults['currentTheme'] = static::DEFAULT_CURRENT_THEME;
		$this->defaults['fallbackTheme'] = static::DEFAULT_FALLBACK_THEME;
	}
	
	/*
	 * @inheritdoc
	 */
	public function loadConfiguration()
	{
		parent::loadConfiguration();
		
		$config = $this->validateConfig($this->defaults);
		$containerBuilder = $this->getContainerBuilder();
		
		Validators::assert($config, 'array');
		
		Validators::assertField($config, 'themesDir', 'string');
		$themesDir = $this->validateDirectory($config['themesDir']);
		
		Validators::assertField($config, 'currentTheme', 'string');
		$currentTheme = $config['currentTheme'];
		
		Validators::assertField($config, 'fallbackTheme', 'string');
		$fallbackTheme = $config['fallbackTheme'];
		
		$containerBuilder->addDefinition($this->prefix('themeManager'))
			->setClass('JR\Themed\ThemeManager\RuntimeThemeManager', [
				$themesDir,
				$currentTheme,
				$fallbackTheme,
			]);
	}
	
	/**
	 * @param string
	 * @return string
	 * @throws DirectoryNotFoundException
	 */
	private function validateDirectory($directory)
	{
		if (($realpath = realpath($directory)) === FALSE || !is_dir($realpath)) {
			throw new DirectoryNotFoundException("Directory '$directory' not found or not accessible.");
		}
		return $realpath;
	}
}
