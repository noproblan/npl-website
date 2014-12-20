<?php

class Admin_Model_Right
{

    protected $_id;

    protected $_roleId;

    protected $_resourceId;

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
            throw new Exception('Ungültige Right Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Right Eigenschaft');
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

    public function setRoleId ($roleId)
    {
        $this->_roleId = (int) $roleId;
        return $this;
    }

    public function getRoleId ()
    {
        return $this->_roleId;
    }

    public function setResourceId ($resourceId)
    {
        $this->_resourceId = (int) $resourceId;
        return $this;
    }

    public function getResourceId ()
    {
        return $this->_resourceId;
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