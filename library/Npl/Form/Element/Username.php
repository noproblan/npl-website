<?php

class Npl_Form_Element_Username extends Zend_Form_Element_Text
{

    public function init ()
    {
        $this->addFilters(
                array(
                        new Zend_Filter_StringTrim(),
                        new Zend_Filter_StripTags()
                ));
        $this->addValidator('regex', true, 
                array(
                        'pattern' => '/^[A-Za-zäöüÄÖÜ][\w.-]*$/',
                        'messages' => array(
                                'regexNotMatch' => 'Muss mit Buchstabe beginnen und darf nur Buchstaben, Zahlen, Punkt, Bindestrich und Unterstrich enthalten.'
                        )
                ));
        $this->addValidators(
                array(
                        new Zend_Validate_StringLength(
                                array(
                                        'min' => 3,
                                        'max' => 20
                                ))
                ));
        $this->setLabel('Benutzername:');
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