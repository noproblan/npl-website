<?php

class Application_Model_Mapper_ResourcesMapper
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
            $this->setDbTable('Application_Model_DbTable_Resources');
        }
        return $this->_dbTable;
    }

    public function save (Application_Model_Resource $resource)
    {
        $data = array(
                'id' => $resource->getId(),
                'controller_name' => $resource->getControllerName(),
                'action_name' => $resource->getActionName()
        );
        
        if (null === ($id = $resource->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array(
                    'id = ?' => $id
            ));
        }
    }

    public function find ($id, Application_Model_Resource $resource)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $resource);
    }

    public function findByControllerAction($controller, $action, Application_Model_Resource $resource)
    {
        $result = $this->getDbTable()->findByControllerAction($controller, $action);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $resource);
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
            $element = new Application_Model_Resource();
            $this->_setValues($row, $element);
            $elements[] = $element;
        }
        return $elements;
    }

    protected function _setValues ($row, Application_Model_Resource $resource)
    {
        $resource->setId($row->id);
        $resource->setControllerName($row->controller_name);
        $resource->setActionName($row->action_name);
        $resource->setWrittenDatetime($row->written_datetime);
    }
}