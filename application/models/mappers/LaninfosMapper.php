<?php

class Application_Model_Mapper_LaninfosMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Ungültiges Table Date Gateway angegeben');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_Laninfos');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Laninfo $laninfo) {
		$data = array(
			'id' => $laninfo->getId(),
			'lan_id' => $laninfo->getLanId(),
			'name' => $laninfo->getName(),
			'info' => $laninfo->getInfo(),
			'order' => $laninfo->getOrder(),
		);
		
		if (null === ($id = $laninfo->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Application_Model_Laninfo $laninfo) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $laninfo);
	}
	
	public function fetchByLanId($lanId)
	{
		return $this->_fetch($this->getDbTable()->fetchByLanId($lanId));
	}
	
	protected function _fetch($resultSet)
	{
		$elements = array();
		foreach ($resultSet as $row) {
			$element = new Application_Model_Laninfo();
			$this->_setValues($row, $element);
			$elements[] = $element;
		}
		return $elements;
	}
	
	protected function _setValues($row, Application_Model_Laninfo $laninfo)
	{
		$laninfo->setId($row->id);
		$laninfo->setLanId($row->lan_id);
		$laninfo->setName($row->name);
		$laninfo->setInfo($row->info);
		$laninfo->setOrder($row->order);
		$laninfo->setWrittenDatetime($row->written_datetime);
	}
}