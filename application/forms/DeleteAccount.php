<?php

class Application_Form_DeleteAccount extends Npl_TableForm
{
    public function init()
    {
        $this->setAttrib('id', 'deleteAccount');
        $this->setAction('');
        $this->setMethod('post');

        $password = new Npl_Form_Element_Password('password');
		$delete = new Zend_Form_Element_Submit(
			'submit', 
			array(
				'class' => 'button',
				'required' => false,
				'ignore' => true,
				'label' => 'Löschen',
			)
		);
        
		$this->addElement($password);
		$this->addElement($delete);
    }
}