<?php

class Application_Model_Mapper_AlbumsMapper
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
            $this->setDbTable('Application_Model_DbTable_Albums');
        }
        return $this->_dbTable;
    }

    public function save (Application_Model_Album $album)
    {
        $data = array(
                'id' => $album->getId(),
                'name' => $album->getName(),
                'folder' => $album->getFolder()
        );
        
        if (null === ($id = $album->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array(
                    'id = ?' => $id
            ));
        }
    }

    public function find ($id, Application_Model_Album $album)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $album);
    }

    public function fetchAll ()
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAll());
    }

    public function fetchAllDesc ()
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAll(null, 'id DESC'));
    }

    protected function _fetch ($resultSet)
    {
        $elements = array();
        foreach ($resultSet as $row) {
            $element = new Application_Model_Album();
            $this->_setValues($row, $element);
            $elements[] = $element;
        }
        return $elements;
    }

    protected function _setValues ($row, Application_Model_Album $album)
    {
        $album->setId($row->id);
        $album->setName($row->name);
        $album->setFolder($row->folder);
        $album->setWrittenDatetime($row->written_datetime);
    }
}