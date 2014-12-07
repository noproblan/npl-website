<?php

class Admin_Form_News_Edit extends Admin_Form_News_New
{
	public function init()
	{
		$id = new Zend_Form_Element_Hidden("id");
		
		$this->addElement($id);
        parent::init();
        $this->setAttrib('id', 'edit_entry');
	}
}