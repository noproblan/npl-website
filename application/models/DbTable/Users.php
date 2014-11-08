<?php

class Application_Model_DbTable_Users extends Npl_Db_Table_Abstract
{
	/** Tabellenname */
	protected $_name = 'npl_users';

	public function findBySalt($salt)
	{
		$where = $this->getAdapter()->quoteInto('salt = ?', $salt);
		return $this->fetchAll($where);
	}
	
	public function findByMail($mail)
	{
		$where = $this->getAdapter()->quoteInto('mail = ?', $mail);
		return $this->fetchAll($where);
	}
}