<?php

class Application_Model_Desk
{

    protected $_id;

    protected $_mapId;

    protected $_deskTypeId;

    protected $_name;

    protected $_positionX;

    protected $_positionY;

    protected $_rotation;

    protected $_height;

    protected $_width;

    protected $_active;

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
            throw new Exception('Ungültige Desk Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Desk Eigenschaft');
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

    /**
     * Sets id
     *
     * @param int $id            
     * @return Application_Model_Desk
     */
    public function setId ($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Gets id
     *
     * @return int
     */
    public function getId ()
    {
        return $this->_id;
    }

    /**
     * Sets map id
     *
     * @param int $mapId            
     * @return Application_Model_Desk
     */
    public function setMapId ($mapId)
    {
        $this->_mapId = (int) $mapId;
        return $this;
    }

    /**
     * Gets map id
     *
     * @return int
     */
    public function getMapId ()
    {
        return $this->_mapId;
    }

    /**
     * Sets desk type id
     *
     * @param int $deskTypeId            
     * @return Application_Model_Desk
     */
    public function setDeskTypeId ($deskTypeId)
    {
        $this->_deskTypeId = (int) $deskTypeId;
        return $this;
    }

    /**
     * Gets desk type id
     *
     * @return int
     */
    public function getDeskTypeId ()
    {
        return $this->_deskTypeId;
    }

    /**
     * Sets name
     *
     * @param string $name            
     * @return Application_Model_Desk
     */
    public function setName ($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName ()
    {
        return $this->_name;
    }

    /**
     * Sets position x coordinate
     *
     * @param int $positionX            
     * @return Application_Model_Desk
     */
    public function setPositionX ($positionX)
    {
        $this->_positionX = (int) $positionX;
        return $this;
    }

    /**
     * Gets position x coordinate
     *
     * @return int
     */
    public function getPositionX ()
    {
        return $this->_positionX;
    }

    /**
     * Sets position y coordinate
     *
     * @param int $positionY            
     * @return Application_Model_Desk
     */
    public function setPositionY ($positionY)
    {
        $this->_positionY = (int) $positionY;
        return $this;
    }

    /**
     * Gets position y coordinate
     *
     * @return int
     */
    public function getPositionY ()
    {
        return $this->_positionY;
    }

    /**
     * Sets rotation in degree
     *
     * @param int $rotation            
     * @return Application_Model_Desk
     */
    public function setRotation ($rotation)
    {
        $this->_rotation = (int) $rotation;
        return $this;
    }

    /**
     * Gets rotation in degree
     *
     * @return int
     */
    public function getRotation ()
    {
        return $this->_rotation;
    }

    /**
     * Sets height
     *
     * @param int $height            
     * @return Application_Model_Desk
     */
    public function setHeight ($height)
    {
        $this->_height = (int) $height;
        return $this;
    }

    /**
     * Gets height
     *
     * @return int
     */
    public function getHeight ()
    {
        return $this->_height;
    }

    /**
     * Sets width
     *
     * @param int $width            
     * @return Application_Model_Desk
     */
    public function setWidth ($width)
    {
        $this->_width = (int) $width;
        return $this;
    }

    /**
     * Gets width
     *
     * @return int
     */
    public function getWidth ()
    {
        return $this->_width;
    }

    /**
     * Sets active
     *
     * @param boolean $active            
     * @return Application_Model_Desk
     */
    public function setActive ($active)
    {
        $this->_active = (bool) $active;
        return $this;
    }

    /**
     * Gets active
     *
     * @return boolean
     */
    public function getActive ()
    {
        return $this->_active;
    }

    /**
     * Sets written datetime
     *
     * @param string $writtenDatetime            
     * @return Application_Model_Desk
     */
    public function setWrittenDatetime ($writtenDatetime)
    {
        $this->_writtenDatetime = date("d.m.Y H:i:s", 
                strtotime($writtenDatetime));
        return $this;
    }

    /**
     * Gets written datetime
     *
     * @return string
     */
    public function getWrittenDatetime ()
    {
        return $this->_writtenDatetime;
    }

    /**
     * Gets seats of this desk
     *
     * @return Application_Model_Seat[]
     */
    public function getSeats ()
    {
        $seatsMapper = new Application_Model_Mapper_SeatsMapper();
        return $seatsMapper->fetchAllByDeskId($this->getId());
    }
}