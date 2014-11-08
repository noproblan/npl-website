<?php

class Application_Model_News
{
	protected $_id;
	protected $_title;
	protected $_authorId;
	protected $_description;
	protected $_writtenDatetime;
	
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
            throw new Exception('Ungültige News Eigenschaft');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige News Eigenschaft');
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
	
	public function setTitle($title)
	{
		$this->_title = (string) $title;
		return $this;
	}
	
	public function getTitle()
	{
		return $this->_title;
	}
	
	public function setAuthorId($authorId)
	{
		$this->_authorId = (int) $authorId;
		return $this;
	}
	
	public function getAuthorId()
	{
		return $this->_authorId;
	}
	
	public function setDescription($description)
	{
		$this->_description = (string) $description;
		return $this;
	}
	
	public function getDescription()
	{
		return $this->_description;
	}
	
	public function setWrittenDatetime($writtenDatetime) {
		$this->_writtenDatetime = date("d.m.Y H:i:s", strtotime($writtenDatetime));
		return $this;
	}
	
	public function getWrittenDatetime() {
		return $this->_writtenDatetime;
	}
}