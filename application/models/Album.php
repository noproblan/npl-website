<?php

class Application_Model_Album
{

    protected $_id;

    protected $_name;

    protected $_folder;

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
            throw new Exception('Ungültige Album Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Album Eigenschaft');
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
     * @return Application_Model_Album
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
     * Sets name
     *
     * @param string $name            
     * @return Application_Model_Album
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
     * Sets folder
     *
     * @param string $folder            
     * @return Application_Model_Album
     */
    public function setFolder ($folder)
    {
        $this->_folder = (string) $folder;
        return $this;
    }

    /**
     * Gets folder
     *
     * @return string
     */
    public function getFolder ()
    {
        return $this->_folder;
    }

    /**
     * Sets written datetime
     *
     * @param string $writtenDatetime            
     * @return Application_Model_Album
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
}