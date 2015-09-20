<?php

namespace JR\Themed;

use JR\Themed\InvalidStateException;

/**
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
trait TTemplateFileFormatterAware
{
	/** @var ITemplateFileFormatter */
	private $templateFileFormatter;
	
	/**
	 * @param ITemplateFileFormatter
	 * @return void
	 */
	public function injectTemplateFileFormatter(ITemplateFileFormatter $templateFileFormatter)
	{
		$this->templateFileFormatter = $templateFileFormatter;
	}
	
	/**
	 * @return ITemplateFileFormatter
	 * @throws InvalidStateException
	 */
	public function getTemplateFileFormatter()
	{
		if ($this->templateFileFormatter === NULL) {
			throw new InvalidStateException(sprintf('Template file formatter was not set. Did you forget to call %s::injectTemplateFileFormatter()?', get_called_class()));
		}
		return $this->templateFileFormatter;
	}
}
