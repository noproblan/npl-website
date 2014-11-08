<?php

class Admin_Model_Mapper_UserRolesMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Ungültiges Table Date Gateway angegeben');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable() {
		if (null === $this->_dbTable) {
			$this->setDbTable('Admin_Model_DbTable_UserRoles');
		}
		return $this->_dbTable;
	}
	
	public function save(Admin_Model_UserRole $userrole) {
		$data = array(
			'id' => $userrole->getId(),
			'user_id' => $userrole->getUserId(),
			'role_id' => $userrole->getRoleId(),
		);
		
		if (null === ($id = $userrole->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Admin_Model_UserRole $userrole) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $userrole);
	}
	
	public function findByUserId($userId) {
		$resultSet = $this->getDbTable()->findByUserId($userId);
		$userroles = array();
		foreach ($resultSet as $row) {
			$userrole = new Admin_Model_UserRole();
			$this->_setValues($row, $userrole);
			$userroles[] = $userrole;
		}
		return $userroles;
	}	
	
	public function findByRoleId($roleId)
	{
		$resultSet = $this->getDbTable()->findByRoleId($roleId);
		$userroles = array();
		foreach ($resultSet as $row) {
			$userrole = new Admin_Model_UserRole();
			$this->_setValues($row, $userrole);
			$userroles[] = $userrole;
		}
		return $userroles;
	}
	
	public function fetchAll()
	{
		return $this->_fetch($this->getDbTable()->fetchAll());
	}
	
	public function delete(Admin_Model_UserRole $userrole)
	{
		$table = $this->getDbTable();
		$where = $table->getAdapter()->quoteInto('id = ?', $userrole->getId());
		$table->delete($where);
	}
	
	protected function _fetch($resultSet)
	{
		$elements = array();
		foreach ($resultSet as $row) {
			$element = new Admin_Model_UserRole();
			$this->_setValues($row, $element);
			$elements[] = $element;
		}
		return $elements;
	}
	
	protected function _setValues($row, Admin_Model_UserRole $userrole)
	{
		$userrole->setId($row->id);
		$userrole->setUserId($row->user_id);
		$userrole->setRoleId($row->role_id);
		$userrole->setWrittenDatetime($row->written_datetime);
	}
}