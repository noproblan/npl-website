<?php

class Application_Form_Login extends Npl_TableForm
{

    public function init ()
    {
        $this->setAttrib('id', 'login');
        $this->setAction('');
        $this->setMethod('post');
        
        $username = new Npl_Form_Element_Username('username');
        $password = new Npl_Form_Element_Password('password');
        $login = new Zend_Form_Element_Submit('submit', 
                array(
                        'class' => 'button',
                        'required' => false,
                        'ignore' => true,
                        'label' => 'Einloggen'
                ));
        
        $this->addElement($username);
        $this->addElement($password);
        $this->addElement($login);
    }
}