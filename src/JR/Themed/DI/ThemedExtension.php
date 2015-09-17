<?php

namespace JR\Themed\DI;

use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;
use JR\Themed\DirectoryNotFoundException;
use JR\Themed\ThemeManager\SimpleThemeManager;

/**
 * Description of ThemedExtension.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class ThemedExtension extends CompilerExtension
{
	/** @var array */
	public $defaults = [
		'themesDir' => NULL,
		'defaultTheme' => NULL,
		'defaultFallbackTheme' => NULL,
	];
	
	/**
	 * @throws DirectoryNotFoundException
	 */
	public function __construct()
	{
		$this->defaults['themesDir'] = $this->validateDirectory(__DIR__ . '/../../../../../../resources/themes');
		$this->defaults['defaultTheme'] = SimpleThemeManager::$defaultTheme;
		$this->defaults['defaultFallbackTheme'] = SimpleThemeManager::$defaultFallbackTheme;
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
		
		$containerBuilder->addDefinition($this->prefix('themeManager'))
			->setClass('JR\Themed\ThemeManager\SimpleThemeManager', [
				$themesDir,
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
