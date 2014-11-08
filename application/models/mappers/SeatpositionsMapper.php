<?php

class Application_Model_Mapper_SeatpositionsMapper
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
			$this->setDbTable('Application_Model_DbTable_Seatpositions');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Seatposition $seatposition)
	{
		$data = array(
			'id' => $seatposition->getId(),
			'name' => $seatposition->getName(),
			'position_x' => $seatposition->getPositionX(),
			'position_y' => $seatposition->getPositionY(),
		);
		
		if (null === ($id = $seatposition->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Application_Model_Seatposition $seatposition)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $seatposition);
	}
	
	public function fetchAll()
	{
		return $this->_fetch($this->getDbTable()->fetchAll());
	}
	
	protected function _fetch($resultSet)
	{
		$elements = array();
		foreach ($resultSet as $row) {
			$element = new Application_Model_Seatposition();
			$this->_setValues($row, $element);
			$elements[] = $element;
		}
		return $elements;
	}
	
	protected function _setValues($row, Application_Model_Seatposition $seatposition)
	{
		$seatpostion->setId($row->id);
		$seatpostion->setName($row->name);
		$seatpostion->setPositionX($row->position_x);
		$seatpostion->setPositionY($row->position_y);
		$seatpostion->setWrittenDatetime($row->written_datetime);
	}
}