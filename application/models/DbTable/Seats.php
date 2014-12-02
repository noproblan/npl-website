<?php

class Application_Model_DbTable_Seats extends Npl_Db_Table_Abstract
{

    /**
     * Tabellenname
     */
    protected $_name = 'npl_srs_seats';

    public function fetchAllByDeskId ($deskId)
    {
        $where = $this->getAdapter()->quoteInto('desk_id = ?', $deskId, 
                'INTEGER');
        return $this->fetchAll($where);
    }

    public function fetchActiveByDeskId ($deskId)
    {
        $where = array(
                $this->getAdapter()->quoteInto('desk_id = ?', $deskId, 
                        'INTEGER') .
                         $this->getAdapter()->quoteInto('active = ?', 1, 
                                'INTEGER')
        );
        return $this->fetchAll($where);
    }
}