<?php

class Admin_Form_News_New extends Zend_Form
{
	public function init()
	{
		$this->setAttrib('id', 'new_entry');
		$this->setAction('');
		$this->setMethod('post');

        $title = new Zend_Form_Element_Text("title");
        $title->setLabel('Titel');
        // TODO: Check filters
        $title->addFilters(
            array(
                new Zend_Filter_Alnum(),
                new Zend_Filter_HtmlEntities(),
                new Zend_Filter_StringTrim(),
                new Zend_Filter_StripNewlines(),
                new Zend_Filter_StripTags()
            )
        );
        $title->addValidators(
            array(
                new Zend_Validate_StringLength(
                    array(
                        'min' => 3,
                        'max' => 255
                    )
                ),
            )
        );
        $description = new Zend_Form_Element_Textarea("description");
        $description->setLabel('Text:');
        $description->addValidators(
            array(
                new Zend_Validate_StringLength(
                    array(
                        'min' => 3
                    )
                )
            )
        );
		$submit = new Zend_Form_Element_Submit(
			'submit', 
			array(
				'required' => false,
				'ignore' => true,
				'label' => 'Erstellen',
			)
		);
		
		$this->addElement($title);
		$this->addElement($description);
        $this->addElement($submit);
	}
}