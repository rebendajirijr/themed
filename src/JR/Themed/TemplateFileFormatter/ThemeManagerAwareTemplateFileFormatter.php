<?php

namespace JR\Themed\TemplateFileFormatter;

use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;
use Nette\Object;
use Nette\Utils\Strings;
use JR\Themed\Helpers;
use JR\Themed\ITemplateFileFormatter;
use JR\Themed\IThemeManager;
use JR\Themed\TThemeManagerAware;

/**
 * Description of ThemeManagerAwareTemplateFileFormatter.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class ThemeManagerAwareTemplateFileFormatter extends Object implements ITemplateFileFormatter
{
	use TThemeManagerAware;
	
	public function __construct(IThemeManager $themeManager)
	{
		$this->injectThemeManager($themeManager);
	}
	
	/*
	 * @inheritdoc
	 */
	public function formatLayoutFile(Presenter $presenter)
	{
		$layoutFiles = [];
		
		$layout = $presenter->getLayout() ? $presenter->getLayout() : 'layout';
		
		foreach ([$this->getThemeManager()->getCurrentTheme(), $this->getThemeManager()->getFallbackTheme()] as $theme) {
			$name = $presenter->getName();
			$presenterName = substr($name, strrpos(':' . $name, ':'));
			
			$dir = $this->unifyDirectorySeparators($this->getThemeManager()->getThemesDir() . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . $presenter->getReflection()->getNamespaceName());
			$dir = is_dir("$dir/templates") ? $dir : dirname($dir);

			$layoutFiles[] = $this->unifyDirectorySeparators("$dir/templates/$presenterName/@$layout.latte");
			$layoutFiles[] = $this->unifyDirectorySeparators("$dir/templates/$presenterName.@$layout.latte");

			do {
				$layoutFiles[] = $this->unifyDirectorySeparators("$dir/templates/@$layout.latte");
				$dir = dirname($dir);
			} while ($dir && ($name = substr($name, 0, strrpos($name, ':'))));
		}
		
		
		return $layoutFiles;
	}
	
	/*
	 * @inheritdoc
	 */
	public function formatTemplateFile(Control $control)
	{
		$templateFiles = [];
		if ($control instanceof Presenter) {
			$namespaceName = $control->getReflection()->getNamespaceName();
			$trimmedName = $control->getReflection()->getShortName();
			if (Strings::endsWith($trimmedName, 'Presenter')) {
				$trimmedName = Strings::substring($trimmedName, 0, Strings::length($trimmedName) - 9);
			}
			
			$templateFiles[] = $this->unifyDirectorySeparators($this->getThemeManager()->getThemesDir() . DIRECTORY_SEPARATOR . $this->getThemeManager()->getCurrentTheme() . DIRECTORY_SEPARATOR . $namespaceName . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $trimmedName . DIRECTORY_SEPARATOR . $control->getAction() . '.latte');
			$templateFiles[] = $this->unifyDirectorySeparators($this->getThemeManager()->getThemesDir() . DIRECTORY_SEPARATOR . $this->getThemeManager()->getFallbackTheme() . DIRECTORY_SEPARATOR . $namespaceName . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $trimmedName . DIRECTORY_SEPARATOR . $control->getAction() . '.latte');
			
			if (Strings::endsWith($namespaceName, '\Presenters')) {
				$trimmedNamespaceName = Strings::substring($control->getReflection()->getNamespaceName(), 0, Strings::length($namespaceName) - 11); // trim /Presenters from namespace
				$templateFiles[] = $this->unifyDirectorySeparators($this->getThemeManager()->getThemesDir() . DIRECTORY_SEPARATOR . $this->getThemeManager()->getCurrentTheme() . DIRECTORY_SEPARATOR . $trimmedNamespaceName . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $trimmedName . DIRECTORY_SEPARATOR . $control->getAction() . '.latte');
				$templateFiles[] = $this->unifyDirectorySeparators($this->getThemeManager()->getThemesDir() . DIRECTORY_SEPARATOR . $this->getThemeManager()->getFallbackTheme() . DIRECTORY_SEPARATOR . $trimmedNamespaceName . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $trimmedName . DIRECTORY_SEPARATOR . $control->getAction() . '.latte');
			}
		} else {
			$templateFiles[] = $this->unifyDirectorySeparators($this->getThemeManager()->getThemesDir() . DIRECTORY_SEPARATOR . $this->getThemeManager()->getCurrentTheme() . DIRECTORY_SEPARATOR . $control->getReflection()->getName() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $control->getReflection()->getShortName() . '.latte');
			$templateFiles[] = $this->unifyDirectorySeparators($this->getThemeManager()->getThemesDir() . DIRECTORY_SEPARATOR . $this->getThemeManager()->getFallbackTheme() . DIRECTORY_SEPARATOR . $control->getReflection()->getName() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $control->getReflection()->getShortName() . '.latte');
		}
		return $templateFiles;
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
