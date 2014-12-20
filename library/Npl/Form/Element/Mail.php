<?php

class Npl_Form_Element_Mail extends Zend_Form_Element_Text
{

    public function init ()
    {
        $this->addFilters(
                array(
                        new Zend_Filter_StringToLower(),
                        new Zend_Filter_StringTrim(),
                        new Zend_Filter_StripTags()
                ));
        $this->addValidators(
                array(
                        new Zend_Validate_EmailAddress(),
                        new Zend_Validate_StringLength(
                                array(
                                        'min' => 6,
                                        'max' => 80
                                ))
                ));
        $this->setLabel('Mailadresse:');
        $this->setRequired(true);
    }

    public function loadDefaultDecorators ()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }
        
        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                ->addDecorator('Description', 
                    array(
                            'tag' => 'p',
                            'class' => 'description'
                    ))
                ->addDecorator('HtmlTag', 
                    array(
                            'tag' => 'dd',
                            'id' => array(
                                    'callback' => array(
                                            get_class($this),
                                            'resolveElementId'
                                    )
                            )
                    ))
                ->addDecorator('Label', array(
                    'tag' => 'dt'
            ));
        }
        return $this;
    }
}