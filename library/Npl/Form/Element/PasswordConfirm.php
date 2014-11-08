<?php

class Npl_Form_Element_PasswordConfirm extends Npl_Form_Element_Password
{
	public function init()
	{
		parent::init();
		$this->addValidators(
			array(
				new Zend_Validate_Identical(
					array(
						'token' => 'password',
					)
				),
			)
		);
		$this->setLabel('Passwort wiederholen:');
	}
}