<?php

class Application_Model_DbTable_Maps extends Npl_Db_Table_Abstract
{
	/** Tabellenname */
	protected $_name = 'npl_srs_maps';
	
	public function fetchAllByLanId($lanId)
	{
		$where = $this->getAdapter()->quoteInto('lan_id = ?', $lanId);
		return $this->fetchAll($where);
	}
	
}