<?php

class Application_Form_ChangeMail extends Npl_TableForm
{
    public function init()
    {        
        $this->setAttrib('id', 'changeMail');
        $this->setAction('');
        $this->setMethod('post');
         
        $mail = new Npl_Form_Element_MailNotInDb('mail');
        $mail->setLabel("Neue Mailadresse:");
        $change = new Zend_Form_Element_Submit(
        		'submit',
        		array(
        				'class' => 'button',
        				'required' => false,
        				'ignore' => true,
        				'label' => 'Mailadresse ändern',
        		)
        );
         
        $this->addElement($mail);
        $this->addElement($change);
    }
}