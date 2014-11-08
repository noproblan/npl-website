<?php

class Application_Model_DbTable_Lans extends Npl_Db_Table_Abstract
{
	/** Tabellenname */
	protected $_name = 'npl_lans';

	public function fetchCurrent()
	{
		$select = new Zend_Db_Table_Select($this);
		$select->from($this->_name)
		->where('start_datetime <= "' . date("Y-m-d h:i:s", time()) . '"')
		->where('end_datetime >= "' . date("Y-m-d h:i:s", time()) . '"')
		->order(array('start_datetime', 'end_datetime', 'name'));
		return $this->fetchAll($select);
	}
	
	public function fetchComing()
	{
		$select = new Zend_Db_Table_Select($this);
		$select->from($this->_name)
		->where('start_datetime > "' . date("Y-m-d h:i:s", time()) . '"')
		->order(array('start_datetime', 'end_datetime', 'name'));
		return $this->fetchAll($select);
	}
	
	public function fetchPassed()
	{
		$select = new Zend_Db_Table_Select($this);
		$select->from($this->_name)
		->where('end_datetime < "' . date("Y-m-d h:i:s", time()) . '"')
		->order(array('start_datetime DESC', 'end_datetime', 'name'));
		return $this->fetchAll($select);
	}
	
}