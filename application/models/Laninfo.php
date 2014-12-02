<?php

class Application_Model_Laninfo
{

    protected $_id;

    protected $_name;

    protected $_lanId;

    protected $_info;

    protected $_order;

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
            throw new Exception('Ungültige Laninfo Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Laninfo Eigenschaft');
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

    public function setName ($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getName ()
    {
        return $this->_name;
    }

    public function setLanId ($lanId)
    {
        $this->_lanId = (int) $lanId;
        return $this;
    }

    public function getLanId ()
    {
        return $this->_lanId;
    }

    public function setInfo ($info)
    {
        $this->_info = (string) $info;
        return $this;
    }

    public function getInfo ()
    {
        return $this->_info;
    }

    public function setOrder ($order)
    {
        $this->_order = (int) $order;
        return $this;
    }

    public function getOrder ()
    {
        return $this->_order;
    }

    public function setWrittenDatetime ($writtenDatetime)
    {
        $this->_writtenDatetime = date("d.m.Y H:i:s", 
                strtotime($writtenDatetime));
        return $this;
    }

    public function getWrittenDatetime ()
    {
        return $this->_writtenDatetime;
    }
}