<?php

class Npl_Helper_InstantMessenger
{
	private $_messenger;
	
	private function loadMessenger()
	{
		$this->_messenger = Zend_Registry::get('InstantMessenger');
	}
	
	private function saveMessenger()
	{
		Zend_Registry::set('InstantMessenger', $this->_messenger);
	}
	
	public function removeErrors()
	{
		$this->loadMessenger();
		$result = $this->_messenger['error'];
		$this->_messenger['error'] = array();
		$this->saveMessenger();
		return $result;
	}
	
	public function removeNotices()
	{
		$this->loadMessenger();
		$result = $this->_messenger['notice'];
		$this->_messenger['notice'] = array();
		$this->saveMessenger();
		return $result;
	}
	
	public function removeSuccesses()
	{
		$this->loadMessenger();
		$result = $this->_messenger['success'];
		$this->_messenger['success'] = array();
		$this->saveMessenger();
		return $result;
	}
	
	public function getErrors()
	{
		$this->loadMessenger();
		$result = $this->_messenger['error'];
		return $result;
	}
	
	public function getNotices()
	{
		$this->loadMessenger();
		$result = $this->_messenger['notice'];
		return $result;
	}
	
	public function getSuccesses()
	{
		$this->loadMessenger();
		$result = $this->_messenger['success'];
		return $result;
	}
	
	public function addError($error)
	{
		$this->loadMessenger();
		array_push($this->_messenger['error'], $error);
		$this->saveMessenger();
	}
	
	public function addNotice($notice)
	{
		$this->loadMessenger();
		array_push($this->_messenger['notice'], $notice);
		$this->saveMessenger();
	}
	
	public function addSuccess($success)
	{
		$this->loadMessenger();
		array_push($this->_messenger['success'], $success);
		$this->saveMessenger();
	}
	
	public function deleteMessages()
	{
		$this->_messenger['error'] = array();
		$this->_messenger['notice'] = array();
		$this->_messenger['succes'] = array();
	}
	
	public function hasErrors()
	{
		$counter = 0;
		foreach ($this->getErrors() as $error) {
			$counter = $this->incrementCounter($counter);
		}
		return $counter > 0;
	}
	
	public function hasNotices()
	{
		$counter = 0;
		foreach ($this->getNotices() as $notice) {
			$counter = $this->incrementCounter($counter);
		}
		return $counter > 0;
	}
	
	public function hasSuccesses()
	{
		$counter = 0;
		foreach ($this->getSuccesses() as $success) {
			$counter = $this->incrementCounter($counter);
		}
		return $counter > 0;
	}
	
	private function incrementCounter($counter) 
	{
		return $counter += 1;
	}
}