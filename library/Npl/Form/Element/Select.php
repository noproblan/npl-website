<?php

class Npl_Form_Element_Select extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Select:');
		$this->setRequired(true);
	}
	
	public function loadDefaultDecorators()
	{
		if ($this->loadDefaultDecoratorsIsDisabled()) {
			return $this;
		}
	
		$decorators = $this->getDecorators();
		if (empty($decorators)) {
			$this->addDecorator('ViewHelper')
			->addDecorator('Description', array('tag' => 'p', 'class' => 'description'))
			->addDecorator('HtmlTag', array(
					'tag' => 'dd',
					'id'  => array('callback' => array(get_class($this), 'resolveElementId'))
			))
			->addDecorator('Label', array('tag' => 'dt'));
		}
		return $this;
	}
}