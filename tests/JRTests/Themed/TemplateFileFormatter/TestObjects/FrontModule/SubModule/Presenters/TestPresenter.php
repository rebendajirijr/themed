<?php

namespace JRTests\Themed\TemplateFileFormatter\TestObjects\FrontModule\SubModule\Presenters;

use Nette\Application\UI\Presenter;

/**
 * Description of TestPresenter.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class TestPresenter extends Presenter
{
	/*
	 * @inheritdoc
	 */
	public function getName()
	{
		return 'Front:Sub:Test';
	}
}
