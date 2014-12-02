<?php

class Application_Model_DbTable_Tickets extends Npl_Db_Table_Abstract
{

    /**
     * Tabellenname
     */
    protected $_name = 'npl_srs_tickets';

    public function fetchAllByLanAndUserId ($lanId, $userId)
    {
        $where = array(
                $this->getAdapter()->quoteInto('lan_id = ?', $lanId),
                $this->getAdapter()->quoteInto('user_id = ?', $userId)
        );
        return $this->fetchAll($where, array(
                'id'
        ));
    }

    public function fetchAllByLanId ($lanId)
    {
        $where = $this->getAdapter()->quoteInto('lan_id = ?', $lanId);
        return $this->fetchAll($where, array(
                'id'
        ));
    }

    public function fetchAllBySeatId ($seatId)
    {
        $where = $this->getAdapter()->quoteInto('seat_id = ?', $seatId);
        return $this->fetchAll($where, array(
                'id'
        ));
    }

    public function fetchAllByUserId ($userId)
    {
        $where = $this->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->fetchAll($where, array(
                'id'
        ));
    }

    public function fetchAllWithSeatByLanId ($lanId)
    {
        $where = array(
                $this->getAdapter()->quoteInto('lan_id = ?', $lanId),
                'seat_id IS NOT NULL'
        );
        return $this->fetchAll($where, array(
                'id'
        ));
    }
}