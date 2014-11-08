<?php

class Admin_Model_DbTable_Resources extends Npl_Db_Table_Abstract
{
	/** Tabellenname */
	protected $_name = 'npl_admin_resources';
	
	public function fetchResources()
	{
		$select = new Zend_Db_Table_Select($this);
		$select->from($this->_name, array('id','controller_name'))
		->order('id')
		->group('controller_name');
		return $this->fetchAll($select);
	}
}