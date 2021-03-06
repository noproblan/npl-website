<?php

class Admin_Form_Rights_RoleEdit extends Zend_Form
{

    public function init ()
    {
        $this->setAttrib('id', 'editRoleForm');
        $this->setAction('');
        $this->setMethod('post');
        
        $username = new Npl_Form_Element_Username('username');
        $password = new Npl_Form_Element_Password('password');
        $login = new Zend_Form_Element_Submit('submit', 
                array(
                        'required' => false,
                        'ignore' => true,
                        'label' => 'Einloggen'
                ));
        
        $this->addElement($username);
        $this->addElement($password);
        $this->addElement($login);
    }
}