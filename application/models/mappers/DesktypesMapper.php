<?php

class Application_Model_Mapper_DesktypesMapper
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
			$this->setDbTable('Application_Model_DbTable_Desktypes');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Desktype $desktype)
	{
		$data = array(
			'id' => $desktype->getId(),
			'name' => $desktype->getName(),
			'color' => $desktype->getColor(),
		);
		
		if (null === ($id = $desktype->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Application_Model_Desktype $desktype)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $desktype);
	}
	
	public function fetchAll()
	{
		return $this->_fetch($this->getDbTable()->fetchAll());
	}
	
	protected function _fetch($resultSet)
	{
		$elements = array();
		foreach ($resultSet as $row) {
			$element = new Application_Model_Desktype();
			$this->_setValues($row, $element);
			$elements[] = $element;
		}
		return $elements;
	}
	
	protected function _setValues($row, Application_Model_Desktype $desktype)
	{
		$desktype->setId($row->id);
		$desktype->setName($row->name);
		$desktype->setColor($row->color);
		$desktype->setWrittenDatetime($row->written_datetime);
	}
}