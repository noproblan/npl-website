<?php

class Admin_Model_DbTable_UserRoles extends Npl_Db_Table_Abstract
{

    /**
     * Tabellenname
     */
    protected $_name = 'npl_admin_userroles';

    public function findByUserId ($userId)
    {
        $where = $this->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->fetchAll($where);
    }

    public function findByRoleId ($roleId)
    {
        $where = $this->getAdapter()->quoteInto('role_id = ?', $roleId);
        return $this->fetchAll($where);
    }
}