<?php

class Application_Model_Mapper_SponsorsMapper
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
            $this->setDbTable('Application_Model_DbTable_Sponsors');
        }
        return $this->_dbTable;
    }

    public function save (Application_Model_Sponsor $sponsor)
    {
        $data = array(
                'id' => $sponsor->getId(),
                'picture_name' => $sponsor->getPictureName(),
                'link' => $sponsor->getLink(),
                'folder' => $sponsor->getFolder()
        );
        
        if (null === ($id = $sponsor->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array(
                    'id = ?' => $id
            ));
        }
    }

    public function find ($id, Application_Model_Sponsor $sponsor)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $sponsor);
    }

    public function fetchAll ()
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAll(null, array(
                'name'
        )));
    }

    protected function _fetch ($resultSet)
    {
        $elements = array();
        foreach ($resultSet as $row) {
            $element = new Application_Model_Sponsor();
            $this->_setValues($row, $element);
            $elements[] = $element;
        }
        return $elements;
    }

    protected function _setValues ($row, Application_Model_Sponsor $sponsor)
    {
        $sponsor->setId($row->id);
        $sponsor->setName($row->name);
        $sponsor->setPictureName($row->picture_name);
        $sponsor->setLink($row->link);
        $sponsor->setWrittenDatetime($row->written_datetime);
    }
}