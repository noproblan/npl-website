<?php

class Admin_Model_Mapper_RolesMapper
{

    protected $_dbTable;

    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Ungültiges Table Date Gateway angegeben');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Admin_Model_DbTable_Roles');
        }
        return $this->_dbTable;
    }

    public function save (Admin_Model_Role $role)
    {
        $data = array(
                'id' => $role->getId(),
                'name' => $role->getName()
        );
        
        if (null === ($id = $role->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array(
                    'id = ?' => $id
            ));
        }
    }

    public function find ($id, Admin_Model_Role $role)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $role);
    }

    public function findByRoleName($roleName) {
        return $this->_fetch($this->getDbTable()
            ->findByRoleName($roleName));
    }

    public function fetchAll ()
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAll());
    }

    protected function _fetch ($resultSet)
    {
        $elements = array();
        foreach ($resultSet as $row) {
            $element = new Admin_Model_Role();
            $this->_setValues($row, $element);
            $elements[] = $element;
        }
        return $elements;
    }

    protected function _setValues ($row, Admin_Model_Role $role)
    {
        $role->setId($row->id);
        $role->setName($row->name);
        $role->setWrittenDatetime($row->written_datetime);
    }
}