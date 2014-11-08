<?php

class Application_Model_Sponsor
{
	protected $_id;
	protected $_name;
	protected $_pictureName;
	protected $_link;
	protected $_writtenDatetime;
	
	const PICTURE_PATH = "img/sponsors/";
	
	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
	
	public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige Sponsor Eigenschaft');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige Sponsor Eigenschaft');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
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
	
	public function setId($id)
	{
		$this->_id = (int) $id;
		return $this;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setName($name)
	{
		$this->_name = (string) $name;
		return $this;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function setPictureName($pictureName)
	{
		$this->_pictureName = (string) $pictureName;
		return $this;
	}
	
	public function getPictureName()
	{
		return $this->_pictureName;
	}
	
	public function setLink($link)
	{
		$this->_link = (string) $link;
		return $this;
	}
	
	public function getLink()
	{
		return $this->_link;
	}
	
	public function setWrittenDatetime($writtenDatetime) {
		$this->_writtenDatetime = date("d.m.Y H:i:s", strtotime($writtenDatetime));
		return $this;
	}
	
	public function getWrittenDatetime() {
		return $this->_writtenDatetime;
	}
	
	public function getPicture($baseUrl = '')
	{
		if (!is_null($this->getPictureName())) {
			$path = self::PICTURE_PATH . $this->getPictureName();
			if (file_exists($path)) {
				return '<img src="'. $baseUrl . '/' . $path . '" alt="' . $this->getName() . '" />';
			}
			return $this->getName();
		} else {
			return $this->getName();
		}
	}
}