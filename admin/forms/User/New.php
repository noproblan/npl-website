<?php

class Admin_Form_User_New extends Zend_Form
{

    public function init ()
    {
        $this->setAttrib('id', 'register');
        $this->setAction('');
        $this->setMethod('post');
        
        $username = new Npl_Form_Element_UsernameNotInDb('username');
        $password = new Npl_Form_Element_Password('password');
        $passwordConfirm = new Npl_Form_Element_PasswordConfirm(
                'passwordConfirm');
        $mail = new Npl_Form_Element_MailNotInDb('mail');
        $register = new Zend_Form_Element_Submit('submit', 
                array(
                        'required' => false,
                        'ignore' => true,
                        'label' => 'Registrieren'
                ));
        
        $this->addElement($username);
        $this->addElement($password);
        $this->addElement($passwordConfirm);
        $this->addElement($mail);
        $this->addElement($register);
    }
}