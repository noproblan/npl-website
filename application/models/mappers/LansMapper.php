<?php

class Application_Model_Mapper_LansMapper
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
			$this->setDbTable('Application_Model_DbTable_Lans');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Lan $lan) {
		$data = array(
			'id' => $lan->getId(),
			'name' => $lan->getName(),
			'start_datetime' => $lan->getStartDateTime(),
			'end_datetime' => $lan->getEndDateTime(),
			'registration_end_datetime' => $lan->getRegistrationEndDateTime(),
			'planned_seats' => $lan->getPlannedSeats(),
		);
		
		if (null === ($id = $lan->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Application_Model_Lan $lan) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $lan);
	}
	
	public function fetchCurrent()
	{
		return $this->_fetch($this->getDbTable()->fetchCurrent());
	}
	
	public function fetchComing()
	{
		return $this->_fetch($this->getDbTable()->fetchComing());
	}
	
	public function fetchPassed()
	{
		return $this->_fetch($this->getDbTable()->fetchPassed());
	}
	
	protected function _fetch($resultSet)
	{
		$elements = array();
		foreach ($resultSet as $row) {
			$element = new Application_Model_Lan();
			$this->_setValues($row, $element);
			$elements[] = $element;
		}
		return $elements;
	}
	
	protected function _setValues($row, Application_Model_Lan $lan)
	{
		$lan->setId($row->id);
		$lan->setName($row->name);
		$lan->setStartDateTime($row->start_datetime);
		$lan->setEndDateTime($row->end_datetime);
		$lan->setRegistrationEndDateTime($row->registration_end_datetime);
		$lan->setPlannedSeats($row->planned_seats);
		$lan->setWrittenDatetime($row->written_datetime);
	}
}