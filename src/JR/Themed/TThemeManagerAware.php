<?php

namespace JR\Themed;

use JR\Themed\InvalidStateException;

/**
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
trait TThemeManagerAware
{
	/** @var IThemeManager */
	private $themeManager;
	
	/**
	 * @param IThemeManager
	 * @return void
	 */
	public function injectThemeManager(IThemeManager $themeManager)
	{
		$this->themeManager = $themeManager;
	}
	
	/**
	 * @return IThemeManager
	 * @throws InvalidStateException
	 */
	public function getThemeManager()
	{
		if ($this->themeManager === NULL) {
			throw new InvalidStateException(sprintf('Theme manager was not set. Did you forget to call %s::injectThemeManager()?', get_called_class()));
		}
		return $this->themeManager;
	}
}
