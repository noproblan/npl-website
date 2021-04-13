<?php

class Admin_Model_Resource implements Zend_Acl_Resource_Interface
{

    protected $_id;

    protected $_controllerName;

    protected $_actionName;

    protected $_writtenDatetime;

    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Resource Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Resource Eigenschaft');
        }
        return $this->$method();
    }

    public function setOptions (array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setId ($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId ()
    {
        return $this->_id;
    }

    public function getResourceId()
    {
        return $this->getId();
    }

    public function setControllerName ($controllerName)
    {
        $this->_controllerName = (string) $controllerName;
        return $this;
    }

    public function getControllerName ()
    {
        return $this->_controllerName;
    }

    public function setActionName ($actionName)
    {
        $this->_actionName = (string) $actionName;
        return $this;
    }

    public function getActionName ()
    {
        return $this->_actionName;
    }

    public function setWrittenDatetime ($WrittenDatetime)
    {
        $this->_writtenDatetime = $WrittenDatetime;
        return $this;
    }

    public function getWrittenDatetime ()
    {
        return $this->_writtenDatetime;
    }
}