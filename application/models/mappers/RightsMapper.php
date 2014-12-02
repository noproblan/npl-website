<?php

class Application_Model_Mapper_RightsMapper
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
            $this->setDbTable('Application_Model_DbTable_Rights');
        }
        return $this->_dbTable;
    }

    public function save (Application_Model_Right $right)
    {
        $data = array(
                'id' => $right->getId(),
                'role_id' => $right->getRoleId(),
                'resource_id' => $right->getActionId()
        );
        
        if (null === ($id = $right->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array(
                    'id = ?' => $id
            ));
        }
    }

    public function find ($id, Application_Model_Right $right)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $right);
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
            $element = new Application_Model_Right();
            $this->_setValues($row, $element);
            $elements[] = $element;
        }
        return $elements;
    }

    protected function _setValues ($row, Application_Model_Right $right)
    {
        $right->setId($row->id);
        $right->setRoleId($row->role_id);
        $right->setResourceId($row->resource_id);
        $right->setWrittenDatetime($row->written_datetime);
    }
}