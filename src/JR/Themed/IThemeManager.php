<?php

namespace JR\Themed;

use JR\Themed\DirectoryNotFoundException;

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
	 * @throws DirectoryNotFoundException
	 */
	function setThemesDir($themesDir);
	
	/**
	 * @return string
	 */
	function getThemesDir();
	
	/**
	 * @param string
	 * @return self
	 */
	function setCurrentTheme($theme);
	
	/**
	 * @return string
	 */
	function getCurrentTheme();
	
	/**
	 * @param string
	 * @return self
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