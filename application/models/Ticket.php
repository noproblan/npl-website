<?php

class Application_Model_Ticket
{

    protected $_id;

    protected $_lanId;

    protected $_userId;

    protected $_seatId;

    protected $_extras;

    protected $_status;

    protected $_helping;

    protected $_writtenDatetime;

    const STATUS_NOTPAID = "notpaid";

    const STATUS_PREPAID = "prepaid";

    const STATUS_PAID = "paid";

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
            throw new Exception('Ungültige Ticket Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Ticket Eigenschaft');
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
        $this->_lanId = (int) $lanId;
        return $this;
    }

    public function getLanId ()
    {
        return $this->_lanId;
    }

    public function setSeatId ($seatId)
    {
        $this->_seatId = (int) $seatId;
        return $this;
    }

    public function getSeatId ()
    {
        return $this->_seatId;
    }

    public function setUserId ($userId)
    {
        $this->_userId = (int) $userId;
        return $this;
    }

    public function getUserId ()
    {
        return $this->_userId;
    }

    public function setExtras ($extras)
    {
        $this->_extras = (string) $extras;
        return $this;
    }

    public function getExtras ()
    {
        return $this->_extras;
    }

    public function setStatus ($status)
    {
        $this->_status = (string) $status;
        return $this;
    }

    public function getStatus ()
    {
        return $this->_status;
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

    public function getHelping ()
    {
        return $this->_helping;
    }

    public function setHelping ($isHelping)
    {
        $this->_helping = $isHelping;
        return $this;
    }

    /**
     * Get extras and explode it into an array to separate extras.
     *
     * @return string
     */
    public function getExtrasSplitted ()
    {
        $tmp = explode(',', $this->getExtras());
        $extras = array();
        foreach ($tmp as $extra) {
            if ($extra != "") {
                $extras[$extra] = true;
            }
        }
        return $extras;
    }

    /**
     * Combines an array to a string and set it as extras.
     *
     * @param string $array
     */
    public function setExtrasSplitted ($array)
    {
        if (is_array($array)) {
            $keys = array_keys($array, true);
            $extras = implode(',', $keys);
            $this->setExtras($extras);
        } else {
            throw new Exception('Array expected!');
        }
        return $this;
    }
}