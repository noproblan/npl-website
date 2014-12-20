<?php

class Npl_DecorativeForm extends Zend_Form
{

    public $decorators = array(); // your decorator definition, keyed by
                                   // Zend_Form* class; array () uses Zend
                                   // defaults

    public function __construct ($options = null)
    {
        // plugin form and element decorators
        if (is_array($options) && isset($options['decorators'])) {
            if (is_array($options['decorators'])) {
                $this->decorators = $options['decorators'];
                unset($options['decorators']);
            }
        }
        
        // build the form
        parent::__construct($options);
    }

    public function addElement ($element, $name = null, $options = null)
    {
        // ask the parent to do the work to add the element
        parent::addElement($element, $name, $options);
        
        // now if we did not set a decorator on the element, add our default
        if (null === $options ||
                 (is_array($options) && ! isset($options['decorators']))) {
            if (! $element instanceof Zend_Form_Element) {
                $element = $this->getElement($name);
            }
            foreach ($this->decorators as $class => $decorators) {
                if ($element instanceof $class) {
                    $element->setDecorators($decorators);
                    return $this;
                }
            }
        }
        
        return $this;
    }

    public function loadDefaultDecorators ()
    {
        // if we have a form decorator plugged-in, use it
        if (isset($this->decorators['Zend_Form'])) {
            $this->setDecorators($this->decorators['Zend_Form']);
            
            // otherwise, do the Zend default
        } else {
            parent::loadDefaultDecorators();
        }
    }
}