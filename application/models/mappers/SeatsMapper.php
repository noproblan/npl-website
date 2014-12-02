<?php

class Application_Model_Mapper_SeatsMapper
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
            $this->setDbTable('Application_Model_DbTable_Seats');
        }
        return $this->_dbTable;
    }

    public function save (Application_Model_Seat $seat)
    {
        $data = array(
                'id' => $seat->getId(),
                'desk_id' => $seat->getDeskId(),
                'seat_position_id' => $seat->getSeatPositionId(),
                'name' => $seat->getName(),
                'active' => $seat->getActive()
        );
        
        if (null === ($id = $seat->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array(
                    'id = ?' => $id
            ));
        }
    }

    public function delete (Application_Model_Seat $seat)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $seat->getId());
        $table->delete($where);
    }

    public function find ($id, Application_Model_Seat $seat)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $seat);
    }

    public function fetchAllByDeskId ($deskId)
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAllByDeskId($deskId));
    }

    public function fetchActiveByDeskId ($deskId)
    {
        return $this->_fetch($this->getDbTable()
            ->fetchActiveByDeskId());
    }

    public function fetchReservedByMapId ($mapId)
    {
        // TODO: Nur reservierte Sitze zurückgeben
        // Notice: Überhaupt nötig?
    }

    public function fetchAvailableByMapId ($mapId)
    {
        // TODO: Nur freie Sitze zurückgeben
        // Notice: Überhaupt nötig?
    }

    protected function _fetch ($resultSet)
    {
        $elements = array();
        foreach ($resultSet as $row) {
            $element = new Application_Model_Seat();
            $this->_setValues($row, $element);
            $elements[] = $element;
        }
        return $elements;
    }

    protected function _setValues ($row, Application_Model_Seat $seat)
    {
        $seat->setId($row->id);
        $seat->setDeskId($row->desk_id);
        $seat->setSeatPositionId($row->seat_position_id);
        $seat->setName($row->name);
        $seat->setActive($row->active);
        $seat->setWrittenDatetime($row->written_datetime);
    }
}