<?php

class Application_Form_ChangePassword extends Npl_TableForm
{
    public function init()
    {
    	$this->setAttrib('id', 'changePassword');
    	$this->setAction('');
    	$this->setMethod('post');
    	
    	$oldPassword = new Npl_Form_Element_Password('oldPassword');
    	$oldPassword->setLabel("Altes Passwort:");
    	$newPassword = new Npl_Form_Element_Password('password');
    	$newPassword->setLabel("Neues Passwort:");
    	$newPasswordConfirm = new Npl_Form_Element_PasswordConfirm('passwordConfirm');
    	$newPasswordConfirm->setLabel("Neues Passwort wiederholen:");
    	$change = new Zend_Form_Element_Submit(
    			'submit',
    			array(
    					'class' => 'button',
    					'required' => false,
    					'ignore' => true,
    					'label' => 'Passwort ändern',
    			)
    	);
    	
    	$this->addElement($oldPassword);
    	$this->addElement($newPassword);
    	$this->addElement($newPasswordConfirm);
    	$this->addElement($change);        
    }
}