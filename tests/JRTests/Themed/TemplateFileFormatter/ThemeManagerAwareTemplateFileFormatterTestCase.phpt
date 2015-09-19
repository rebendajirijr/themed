<?php

namespace JRTests\Themed\TemplateFileFormatter;

use Tester\Assert;
use Tester\TestCase;
use JR\Themed\Helpers;
use JR\Themed\TemplateFileFormatter\ThemeManagerAwareTemplateFileFormatter;
use JR\Themed\ThemeManager\RuntimeThemeManager;
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
	/** @var RuntimeThemeManager */
	private $themeManager;
	
	/** @var ThemeManagerAwareTemplateFileFormatter */
	private $themeManagerAwareTemplateFileFormatter;
	
	/*
	 * @inheritdoc
	 */
	protected function setUp()
	{
		parent::setUp();
		
		$this->themeManager = new RuntimeThemeManager(
			__DIR__ . '/data/themes',
			'bootstrap',
			'fallback'
		);
		
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
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test.' . $layoutFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			
			// fallback theme
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test.' . $layoutFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\templates' . DIRECTORY_SEPARATOR . $layoutFileBasename),
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
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\Presenters\templates\Test' . DIRECTORY_SEPARATOR . $actionFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\Presenters\templates\Test' . DIRECTORY_SEPARATOR . $actionFileBasename),
			
			// outside Presenters directory
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test' . DIRECTORY_SEPARATOR . $actionFileBasename),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\templates\Test' . DIRECTORY_SEPARATOR . $actionFileBasename),
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
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getCurrentTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\TestControl\templates\TestControl.latte'),
			$this->unifyDirectorySeparators($this->themeManager->getThemesDir() . DIRECTORY_SEPARATOR . $this->themeManager->getFallbackTheme() . DIRECTORY_SEPARATOR . 'JRTests\Themed\TemplateFileFormatter\TestObjects\TestControl\templates\TestControl.latte'),
		];
		
		Assert::same($expected, $this->themeManagerAwareTemplateFileFormatter->formatTemplateFile($control));
	}
	
	/**
	 * @param string
	 * @return string
	 */
	private function unifyDirectorySeparators($path)
	{
		return Helpers::unifyDirectorySeparators($path);
	}
}

run(new ThemeManagerAwareTemplateFileFormatterTestCase());
