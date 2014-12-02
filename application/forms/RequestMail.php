<?php

class Application_Form_RequestMail extends Npl_TableForm
{

    public function init ()
    {
        $this->setAttrib('id', 'requestMail');
        $this->setAction('');
        $this->setMethod('post');
        
        $mail = new Npl_Form_Element_MailInDb('mail');
        $request = new Zend_Form_Element_Submit('submit', 
                array(
                        'class' => 'button',
                        'required' => false,
                        'ignore' => true,
                        'label' => 'Senden'
                ));
        
        $this->addElement($mail);
        $this->addElement($request);
    }
}