<?php

namespace JRTests\Themed\DI;

use Tester\Assert;
use Tester\TestCase;
use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\Utils\Strings;
use JR\Themed\DI\ThemedExtension;
use JR\Themed\ThemeManager\RuntimeThemeManager;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Description of ThemedExtensionTestCase.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class ThemedExtensionTestCase extends TestCase
{
	/**
	 * @return Configurator
	 */
	private function createConfigurator()
	{
		$configurator = new Configurator();
		$configurator->setTempDirectory(TEMP_DIR);
		$configurator->addParameters([
			'container' => [
				'class' => 'SystemContainer_' . Strings::random(),
			],
		]);
		
		$configurator->onCompile[] = function (Configurator $configurator, Compiler $compiler) {
			$themedExtension = new ThemedExtension();
			$themedExtension->defaults['themesDir'] = __DIR__ . '/data/themes';
			$themedExtension->defaults['currentTheme'] = 'bootstrap';
			$themedExtension->defaults['fallbackTheme'] = 'fallback';
			$compiler->addExtension('themed', $themedExtension);
			
			$extensions = $compiler->getExtensions('Nette\Bridges\ApplicationDI\ApplicationExtension');
			$applicationExtension = array_shift($extensions);
			if ($applicationExtension !== NULL) {
				$applicationExtension->defaults['scanDirs'] = FALSE;
			}
		};
		return $configurator;
	}
	
	/**
	 * @return void
	 */
	public function testConfiguration()
	{
		$configurator = $this->createConfigurator();
		$container = $configurator->createContainer();
		
		/* @var $themeManager RuntimeThemeManager */
		$themeManager = $container->getService('themed.themeManager');
		
		Assert::type('JR\Themed\ThemeManager\RuntimeThemeManager', $themeManager);
		
		$themesDirRealpath = realpath($themeManager->getThemesDir());
		Assert::type('string', $themesDirRealpath);
		Assert::same(realpath(__DIR__ . '/data/themes'), $themesDirRealpath);
		
		Assert::same('bootstrap', $themeManager->getCurrentTheme());
		Assert::same('fallback', $themeManager->getFallbackTheme());
		
		$templateFileFormatter = $container->getService('themed.templateFileFormatter');
		
		Assert::type('JR\Themed\TemplateFileFormatter\ThemeManagerAwareTemplateFileFormatter', $templateFileFormatter);
	}
}

run(new ThemedExtensionTestCase());
