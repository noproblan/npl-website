<?php

class Application_Form_ResetPassword extends Npl_TableForm
{

    public function init ()
    {
        $this->setAttrib('id', 'resetPassword');
        $this->setAction('');
        $this->setMethod('post');
        
        $id = new Zend_Form_Element_Hidden('userid');
        $hash = new Zend_Form_Element_Hidden('userhash');
        $password = new Npl_Form_Element_Password('password');
        $password->setLabel("Neues Passwort:");
        $passwordConfirm = new Npl_Form_Element_PasswordConfirm(
                'passwordConfirm');
        $passwordConfirm->setLabel("Neues Passwort wiederholen:");
        $reset = new Zend_Form_Element_Submit('submit', 
                array(
                        'class' => 'button',
                        'required' => false,
                        'ignore' => true,
                        'label' => 'Passwort speichern'
                ));
        
        $this->addElement($id);
        $this->addElement($hash);
        $this->addElement($password);
        $this->addElement($passwordConfirm);
        $this->addElement($reset);
    }
}