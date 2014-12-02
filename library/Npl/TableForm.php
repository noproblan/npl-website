<?php

class Npl_TableForm extends Npl_DecorativeForm
{

    public $decorators = array(
            'Zend_Form_Element_Submit' => array(
                    'ViewHelper',
                    array(
                            array(
                                    'data' => 'HtmlTag'
                            ),
                            array(
                                    'tag' => 'td',
                                    'class' => 'button'
                            )
                    ),
                    array(
                            array(
                                    'label' => 'HtmlTag'
                            ),
                            array(
                                    'tag' => 'td',
                                    'placement' => 'prepend'
                            )
                    ),
                    array(
                            array(
                                    'row' => 'HtmlTag'
                            ),
                            array(
                                    'tag' => 'tr'
                            )
                    )
            ),
            'Zend_Form_Element_Hidden' => array(
                    'ViewHelper'
            ),
            'Zend_Form_Element_Captcha' => array(
                    array(
                            array(
                                    'data' => 'HtmlTag'
                            ),
                            array(
                                    'tag' => 'td',
                                    'class' => 'element'
                            )
                    ),
                    array(
                            'Label',
                            array(
                                    'tag' => 'th'
                            )
                    ),
                    array(
                            array(
                                    'row' => 'HtmlTag'
                            ),
                            array(
                                    'tag' => 'tr'
                            )
                    )
            ),
            'Zend_Form_Element' => array(
                    'ViewHelper',
                    array(
                            array(
                                    'data' => 'HtmlTag'
                            ),
                            array(
                                    'tag' => 'td',
                                    'class' => 'element'
                            )
                    ),
                    array(
                            'Label',
                            array(
                                    'tag' => 'th'
                            )
                    ),
                    array(
                            array(
                                    'row' => 'HtmlTag'
                            ),
                            array(
                                    'tag' => 'tr'
                            )
                    )
            ),
            'Zend_Form' => array(
                    'FormElements',
                    array(
                            'HtmlTag',
                            array(
                                    'tag' => 'table'
                            )
                    ),
                    'Form'
            )
    );
}
?>