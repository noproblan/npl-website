<?php
class Npl_AccessibleForm extends Npl_DecorativeForm {
	public $decorators = array (
			'Zend_Form_Element_Submit' => array (
					'ViewHelper',
					array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'button')),
					array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
			),
			'Zend_Form_Element_Captcha' => array (
					'Label',
					array (array ('row' => 'HtmlTag'), array ('tag' => 'li'))
			),
			'Zend_Form_Element_Checkbox' => array (
					'Label',
					'ViewHelper',
					array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'checkbox')),
					array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
			),
			'Zend_Form_Element_Radio' => array (
					'Label',
					'ViewHelper',
					array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'radio')),
					array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
			),
			'Zend_Form_Element' => array (
					'ViewHelper',
					array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'element')),
					'Label',
					array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
			),
			'Zend_Form' => array (
					'FormElements',
					array ('HtmlTag', array ('tag' => 'ol')),
					'Form'
			),
	);

}