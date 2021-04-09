<?php

class Application_Model_DbTable_Resources extends Npl_Db_Table_Abstract
{

    /**
     * Tabellenname
     */
    protected $_name = 'npl_resources';

    public function findByControllerAction ($controller, $action)
    {
        $select = new Zend_Db_Table_Select($this);
        $select->from($this->_name)
            ->where('controller_name = ?', $controller)
            ->where('action_name = ?', $action);
        return $this->fetchAll($select);
    }
}