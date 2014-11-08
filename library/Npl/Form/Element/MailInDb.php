<?php

class Npl_Form_Element_MailInDb extends Npl_Form_Element_Mail
{
	public function init()
	{
		parent::init();
		$this->addValidators(
			array(
				new Zend_Validate_Db_RecordExists(
					array(
						'table' => 'npl_users',
						'field' => 'mail',
					)
				),
			)
		);
	}
}