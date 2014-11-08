<?php

class Application_Model_Mapper_DesksMapper
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
			$this->setDbTable('Application_Model_DbTable_Desks');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Desk $desk)
	{
		$data = array(
			'id' => $desk->getId(),
			'map_id' => $desk->getMapId(),
			'desk_type_id' => $desk->getDeskTypeId(),
			'position_x' => $desk->getPositionX(),
			'position_y' => $desk->getPositionY(),
			'rotation' => $desk->getRotation(),
			'height' => $desk->getHeight(),
			'width' => $desk->getWidth(),
			'active' => $desk->getActive(),
		);
		
		if (null === ($id = $desk->getId())) {
			unset($data['id']);
			$desk->setId($this->getDbTable()->insert($data));
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function delete(Application_Model_Desk $desk)
	{
		$table = $this->getDbTable();
		$where = $table->getAdapter()->quoteInto('id = ?', $desk->getId());
		$table->delete($where);
	}
	
	public function find($id, Application_Model_Desk $desk)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $desk);
	}
	
	public function fetchAllByMapId($mapId)
	{
		return $this->_fetch($this->getDbTable()->fetchAllByMapId($mapId));
	}
	
	public function fetchActiveByMapId($mapId)
	{
		return $this->_fetch($this->getDbTable()->fetchActiveByMapId($mapId));
	}
	
	public function fetchAllOfTypeByMapId($typeId, $mapId)
	{
		return $this->_fetch($this->getDbTable()->fetchAllOfTypeByMapId($typeId, $mapId));
	}
	
public function fetchActiveOfTypeByMapId($typeId, $mapId)
	{
		return $this->_fetch($this->getDbTable()->fetchActiveOfTypeByMapId($typeId, $mapId));
	} 
	
	protected function _fetch($resultSet)
	{
		$elements = array();
		foreach ($resultSet as $row) {
			$element = new Application_Model_Desk();
			$this->_setValues($row, $element);
			$elements[] = $element;
		}
		return $elements;
	}
	
	protected function _setValues($row, Application_Model_Desk $desk)
	{
		$desk->setId($row->id);
		$desk->setMapId($row->map_id);
		$desk->setDeskTypeId($row->desk_type_id);
		$desk->setPositionX($row->position_x);
		$desk->setPositionY($row->position_y);
		$desk->setRotation($row->rotation);
		$desk->setHeight($row->height);
		$desk->setWidth($row->width);
		$desk->setActive($row->active);
		$desk->setWrittenDatetime($row->written_datetime);
	}
}