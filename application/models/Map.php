<?php

class Application_Model_Map
{

    protected $_id;

    protected $_lanId = null;

    protected $_name;

    protected $_color;

    protected $_height;

    protected $_width;

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
            throw new Exception('Ungültige Map Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Map Eigenschaft');
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

    public function setLanId ($lanId)
    {
        if (! is_null($lanId))
            $lanId = (int) $lanId;
        $this->_lanId = $lanId;
        return $this;
    }

    public function getLanId ()
    {
        return $this->_lanId;
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

    public function setColor ($color)
    {
        $this->_color = (string) $color;
        return $this;
    }

    public function getColor ()
    {
        return $this->_color;
    }

    public function setHeight ($height)
    {
        $this->_height = (int) $height;
        return $this;
    }

    public function getHeight ()
    {
        return $this->_height;
    }

    public function setWidth ($width)
    {
        $this->_width = (int) $width;
        return $this;
    }

    public function getWidth ()
    {
        return $this->_width;
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

    /**
     * Returns all desks of this map
     * 
     * @return Application_Model_Desk[]
     */
    public function getDesks ()
    {
        $desksMapper = new Application_Model_Mapper_DesksMapper();
        return $desksMapper->fetchAllByMapId($this->getId());
    }
}