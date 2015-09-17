<?php

namespace JR\Themed;

use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;

/**
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
interface ITemplateFileFormatter
{
	/**
	 * Returns array of layout files which should be considered during the layout file search.
	 * 
	 * @param Presenter
	 * @return array
	 */
	function formatLayoutFile(Presenter $presenter);
	
	/**
	 * Returns array of template files which should be considered during the template file search.
	 * 
	 * @param Control
	 * @return array
	 */
	function formatTemplateFile(Control $control);
}
