<?php

namespace JRTests\Themed\TemplateFileFormatter;

use Tester\Assert;
use Tester\TestCase;
use JR\Themed\TemplateFileFormatter\ThemeManagerAwareTemplateFileFormatter;
use JR\Themed\ThemeManager\SimpleThemeManager;
use JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\Presenters\TestPresenter;
use JRTests\Themed\TemplateFileFormatter\TestObjects\TestControl;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Description of ThemeManagerAwareTemplateFileFormatterTestCase.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class ThemeManagerAwareTemplateFileFormatterTestCase extends TestCase
{
	/** @var SimpleThemeManager */
	private $themeManager;
	
	/** @var ThemeManagerAwareTemplateFileFormatter */
	private $themeManagerAwareTemplateFileFormatter;
	
	/*
	 * @inheritdoc
	 */
	protected function setUp()
	{
		parent::setUp();
		
		SimpleThemeManager::$defaultTheme = 'bootstrap';
		SimpleThemeManager::$defaultFallbackTheme = 'fallback';
		$this->themeManager = new SimpleThemeManager(__DIR__ . '/data/themes');
		
		$this->themeManagerAwareTemplateFileFormatter = new ThemeManagerAwareTemplateFileFormatter($this->themeManager);
	}

	/**
	 * @return void
	 */
	public function testFormatLayoutFile()
	{
		$layout = 'myLayout';
		$layoutFileBasename = '@' . $layout . '.latte';
		
		$presenter = new TestPresenter();
		$presenter->setLayout($layout);
		
		$expected = [
			// current theme
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test.' . $layoutFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			
			// fallback theme
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test.' . $layoutFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
		];
		
		Assert::same($expected, $this->themeManagerAwareTemplateFileFormatter->formatLayoutFile($presenter));
	}
	
	/**
	 * @return void
	 */
	public function testFormatPresenterTemplateFile()
	{
		$action = 'foo';
		$actionFileBasename = $action . '.latte';
		
		$presenter = new TestPresenter();
		$presenter->changeAction($action);
		
		$expected = [
			// inside Presenters directory
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\Presenters\templates\Test' . DIRECTORY_SEPARATOR . $actionFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\Presenters\templates\Test' . DIRECTORY_SEPARATOR . $actionFileBasename),
			
			// outside Presenters directory
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test' . DIRECTORY_SEPARATOR . $actionFileBasename),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test' . DIRECTORY_SEPARATOR . $actionFileBasename),
		];
		
		Assert::same($expected, $this->themeManagerAwareTemplateFileFormatter->formatTemplateFile($presenter));
	}
	
	/**
	 * @return void
	 */
	public function testFormatControlTemplateFile()
	{
		$control = new TestControl();
		
		$expected = [
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\TestControl\templates\TestControl.latte'),
			$this->fixDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\TestControl\templates\TestControl.latte'),
		];
		
		Assert::same($expected, $this->themeManagerAwareTemplateFileFormatter->formatTemplateFile($control));
	}
	
	/**
	 * @param string
	 * @return string
	 */
	private function fixDirectorySeparators($path)
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

run(new ThemeManagerAwareTemplateFileFormatterTestCase());
