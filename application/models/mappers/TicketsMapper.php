<?php

class Application_Model_Mapper_TicketsMapper
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
            $this->setDbTable('Application_Model_DbTable_Tickets');
        }
        return $this->_dbTable;
    }

    public function save (Application_Model_Ticket $ticket)
    {
        $data = array(
                'id' => $ticket->getId(),
                'lan_id' => $ticket->getLanId(),
                'user_id' => $ticket->getUserId(),
                'seat_id' => $ticket->getSeatId(),
                'extras' => $ticket->getExtras(),
                'status' => $ticket->getStatus()
        );
        if ($data['seat_id'] == 0)
            unset($data['seat_id']);
        if (is_null($data['extras']))
            $data['extras'] = "";
        if ($data['status'] == "")
            unset($data['status']);
        if (null === ($id = $ticket->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array(
                    'id = ?' => $id
            ));
        }
    }

    public function find ($id, Application_Model_Ticket $ticket)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->_setValues($row, $ticket);
    }

    public function fetchAllByLanAndUserId ($lanId, $userId)
    {
        return $this->_fetch(
                $this->getDbTable()
                    ->fetchAllByLanAndUserId($lanId, $userId));
    }

    public function fetchAllByLanId ($lanId)
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAllByLanId($lanId));
    }

    public function fetchAllBySeatId ($seatId)
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAllBySeatId($seatId));
    }

    public function fetchAllByUserId ($userId)
    {
        return $this->_fetch($this->getDbTable()
            ->fetchAllByUserId($userId));
    }

    public function fetchAllWithSeatByLanId ($lanId)
    {
        return $this->_fetch(
                $this->getDbTable()
                    ->fetchAllWithSeatByLanId($lanId));
    }

    public function delete (Application_Model_Ticket $ticket)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $ticket->getId());
        return $table->delete($where);
    }

    protected function _fetch ($resultSet)
    {
        $elements = array();
        foreach ($resultSet as $row) {
            $element = new Application_Model_Ticket();
            $this->_setValues($row, $element);
            $elements[] = $element;
        }
        return $elements;
    }

    protected function _setValues ($row, Application_Model_Ticket $ticket)
    {
        $ticket->setId($row->id);
        $ticket->setLanId($row->lan_id);
        $ticket->setUserId($row->user_id);
        $ticket->setSeatId($row->seat_id);
        $ticket->setExtras($row->extras);
        $ticket->setStatus($row->status);
        $ticket->setWrittenDatetime($row->written_datetime);
    }
}