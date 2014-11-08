<?php

class Application_Form_ChangeEmail extends Npl_TableForm
{
    public function init()
    {        
        $this->setAttrib('id', 'changeEmail');
        $this->setAction('');
        $this->setMethod('post');
         
        $email = new Npl_Form_Element_EmailNotInDb('email');
        $email->setLabel("Neue E-Mail:");
        $change = new Zend_Form_Element_Submit(
        		'submit',
        		array(
        				'class' => 'button',
        				'required' => false,
        				'ignore' => true,
        				'label' => 'E-Mail ändern',
        		)
        );
         
        $this->addElement($email);
        $this->addElement($change);
    }
}