<?php

class Application_Form_Register extends Npl_TableForm
{
	public function init()
	{
		$this->setAttrib('id', 'register');
		$this->setAction('');
		$this->setMethod('post');
		
		$username = new Npl_Form_Element_UsernameNotInDb('username');
		$password = new Npl_Form_Element_Password('password');
		$passwordConfirm = new Npl_Form_Element_PasswordConfirm('passwordConfirm');
		$mail = new Npl_Form_Element_MailNotInDb('mail');
		$captcha = new Zend_Form_Element_Captcha('humanize', array (
		    'label' => "Captcha:",
		    'captcha' => array (
		        'captcha' => 'Figlet',
		        'wordLen' => 2,
		        'timeout' => 300,
		    	'Messages' => array(
		    		'badCaptcha' => 'Der eingegebene Code ist falsch',
		    		'missingValue' => 'Es wird ein Wert benötigt. Dieser darf nicht leer sein'
		    	)
		    ),
		));
		$captcha->removeDecorator('Errors');
		$register = new Zend_Form_Element_Submit(
			'submit', 
			array(
				'class' => 'button',
				'required' => false,
				'ignore' => true,
				'label' => 'Registrieren',
			)
		);
		
		$this->addElement($username);
		$this->addElement($password);
		$this->addElement($passwordConfirm);
		$this->addElement($mail);
		$this->addElement($captcha);
		$this->addElement($register);
	}
}