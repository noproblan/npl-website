<?php

class Admin_Model_DbTable_Roles extends Npl_Db_Table_Abstract
{

    /**
     * Tabellenname
     */
    protected $_name = 'npl_admin_roles';

    public function findByRoleName($roleName) {
        $where = $this->getAdapter()->quoteInto('name = ?', $roleName);
        return $this->fetchAll($where);
    }
}