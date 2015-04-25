<?php

class Application_Model_Mapper_MapsMapper
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
            $this->setDbTable('Application_Model_DbTable_Maps');
        }
        return $this->_dbTable;
    }

    public function save (Application_Model_Map $map)
    {
        $data = array(
                'id' => $map->getId(),
                'lan_id' => $map->getLanId(),
                'name' => $map->getName(),
                'color' => $map->getColor(),
                'height' => $map->getHeight(),
                'width' => $map->getWidth(),
                'additional_info' => $map->getAdditionalInfo()
        );
        
        if (null === ($id = $map->getId())) {
            unset($data['id']);
            $map->setId($this->getDbTable()
                ->insert($data));
        } else {
            $this->getDbTable()->update($data, array(
                    'id = ?' => $id
            ));
        }
    }

    public function find ($id, Application_Model_Map $map)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $map);
    }

    public function fetchAllByLanId ($lanId)
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAllByLanId($lanId));
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
            $element = new Application_Model_Map();
            $this->_setValues($row, $element);
            $elements[] = $element;
        }
        return $elements;
    }

    protected function _setValues ($row, Application_Model_Map $map)
    {
        $map->setId($row->id);
        $map->setLanId($row->lan_id);
        $map->setName($row->name);
        $map->setColor($row->color);
        $map->setHeight($row->height);
        $map->setWidth($row->width);
        $map->setAdditionalInfo($row->additional_info);
        $map->setWrittenDatetime($row->written_datetime);
    }
}