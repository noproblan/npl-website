<?php

class Application_Model_DbTable_Laninfos extends Npl_Db_Table_Abstract
{

    /**
     * Tabellenname
     */
    protected $_name = 'npl_laninfos';

    public function fetchByLanId ($lanId)
    {
        $select = new Zend_Db_Table_Select($this);
        $select->from($this->_name)
            ->where('lan_id = ' . $lanId)
            ->order(array(
                'order',
                'name'
        ));
        return $this->fetchAll($select);
    }
}