<?php

class Application_Model_Seat
{

    protected $_id;

    protected $_deskId;

    protected $_seatPositionId = null;

    protected $_name;

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
            throw new Exception('Ungültige Seat Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Seat Eigenschaft');
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

    public function setDeskId ($deskId)
    {
        $this->_deskId = (int) $deskId;
        return $this;
    }

    public function getDeskId ()
    {
        return $this->_deskId;
    }

    public function setSeatPositionId ($seatPositionId)
    {
        if (! is_null($seatPositionId))
            $seatPositionId = (int) $seatPositionId;
        $this->_seatPositionId = $seatPositionId;
        return $this;
    }

    public function getSeatPositionId ()
    {
        return $this->_seatPositionId;
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

    public function setActive ($active)
    {
        $this->_active = (bool) $active;
        return $this;
    }

    public function getActive ()
    {
        return $this->_active;
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
     * Checks if there is a ticket with this seat
     *
     * @return boolean
     */
    public function isAvailable ()
    {
        $ticketsMapper = new Application_Model_Mapper_TicketsMapper();
        $tickets = $ticketsMapper->fetchAllBySeatId($this->getId());
        return empty($tickets);
    }
}