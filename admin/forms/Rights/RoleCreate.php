<?php

class Admin_Form_Rights_RoleCreate extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('id', 'createRoleForm');
        $this->setAction('');
        $this->setMethod('post');

        $rolenameText = new Zend_Form_Element_Text("rolename");
        $rolenameText->setLabel("Rollenname");
		$createButton = new Zend_Form_Element_Submit(
			'submit', 
			array(
				'required' => false,
				'ignore' => true,
				'label' => 'erstellen',
			)
		);
        
		$this->addElement($rolenameText);
		$this->addElement($createButton);
    }
}