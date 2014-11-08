<?php

class Application_Model_Mapper_UsersMapper
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
			$this->setDbTable('Application_Model_DbTable_Users');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_User $user) {
		$data = array(
			'id' => $user->getId(),
			'username' => $user->getUsername(),
			'password' => $user->getPassword(),
			'salt' => $user->getSalt(),
			'mail' => $user->getMail(),
			'active' => $user->getActive(),
			'mail_verified' => $user->getMailVerified(),
			'register_datetime' => $user->getRegisterDatetime(),
		);
		
		if (null === ($id = $user->getId())) {
			unset($data['id']);
			$lastId = $this->getDbTable()->insert($data);
			$user->setId($lastId);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Application_Model_User $user) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $user);
	}
	
	public function findBySalt($salt, Application_Model_User $user) {
		$result = $this->getDbTable()->findBySalt($salt);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $user);
	}
	
	public function findByMail($mail, Application_Model_User $user)
	{
		$result = $this->getDbTable()->findByMail($mail);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $user);
	}
	
	/**
	 * Listet alle User aus der Usertabelle
	 * @return Application_Model_User[]
	 */
	public function fetchAll($where = null, $order = null)
	{
		return $this->_fetch($this->getDbTable()->fetchAll($where, $order));
	}
	
	public function delete(Application_Model_User $user) 
	{
		$mapper = new Application_Model_Mapper_UserRolesMapper();
		$userroles = $mapper->findByUserId($user->getId());
		foreach ($userroles as $userrole) {
			$mapper->delete($userrole);
		}
		
		$table = $this->getDbTable();
		$where = $table->getAdapter()->quoteInto('id = ?', $user->getId());
		$table->delete($where);
	}
	
	/**
	 * @param Zend_Db_Table_Rowset_Abstract $resultSet
	 * @return Application_Model_User[]
	 */
	protected function _fetch($resultSet)
	{
		$elements = array();
		foreach ($resultSet as $row) {
			$element = new Application_Model_User();
			$this->_setValues($row, $element);
			$elements[] = $element;
		}
		return $elements;
	}
	
	protected function _setValues($row, Application_Model_User $user)
	{
		$user->setId($row->id);
		$user->setUsername($row->username);
		$user->setPassword($row->password);
		$user->setSalt($row->salt);
		$user->setMail($row->mail);
		$user->setActive($row->active);
		$user->setMailVerified($row->mail_verified);
		$user->setRegisterDatetime($row->register_datetime);
		$user->setWrittenDatetime($row->written_datetime);
	}
}