<?php

class Application_Model_Seatposition
{

    protected $_id;

    protected $_name;

    protected $_positionX;

    protected $_positionY;

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
            throw new Exception('Ungültige Seatposition Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Seatposition Eigenschaft');
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

    public function setPositionX ($positionX)
    {
        $this->_positionX = (int) $positionX;
        return $this;
    }

    public function getPositionX ()
    {
        return $this->_positionX;
    }

    public function setPositionY ($positionY)
    {
        $this->_positionY = (int) $positionY;
        return $this;
    }

    public function getPositionY ()
    {
        return $this->_positionY;
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