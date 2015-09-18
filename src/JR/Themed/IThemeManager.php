<?php

namespace JR\Themed;

/**
 * Description of IThemeManager.
 * 
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
interface IThemeManager
{
	/**
	 * @param string
	 * @return self
	 * @throws InvalidArgumentException
	 */
	function setCurrentTheme($theme);
	
	/**
	 * @return string
	 */
	function getCurrentTheme();
	
	/**
	 * @param string
	 * @return self
	 * @throws InvalidArgumentException
	 */
	function setFallbackTheme($fallbackTheme);
	
	/**
	 * @return string
	 */
	function getFallbackTheme();
	
	/**
	 * Returns all available themes.
	 * 
	 * @return array
	 */
	function getAvailableThemes();
}
