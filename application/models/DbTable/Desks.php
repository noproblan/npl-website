<?php

class Application_Model_DbTable_Desks extends Npl_Db_Table_Abstract
{
	/** Tabellenname */
	protected $_name = 'npl_srs_desks';
	
	public function fetchAllByMapId($mapId)
	{
		$where = $this->getAdapter()->quoteInto('map_id = ?', $mapId);
		return $this->fetchAll($where);
	}
	
	public function fetchActiveByMapId($mapId)
	{
		$where = array(
				$this->getAdapter()->quoteInto('map_id = ?', $mapId),
				$this->getAdapter()->quoteInto('active = ?', 1, 'INTEGER')
		);
		return $this->fetchAll($where);
	}
	
	public function fetchAllOfTypeByMapId($typeId, $mapId)
	{
		$where = array(
				$this->getAdapter()->quoteInto('map_id = ?', $mapId),
				$this->getAdapter()->quoteInto('type_id = ?', $typeId)
		);
		return $this->fetchAll($where);
	}
	
	public function fetchActiveOfTypeByMapId($typeId, $mapId)
	{
		$where = array(
				$this->getAdapter()->quoteInto('map_id = ?', $mapId),
				$this->getAdapter()->quoteInto('type_id = ?', $typeId),
				$this->getAdapter()->quoteInto('active = ?', 1, 'INTEGER')
		);
		return $this->fetchAll($where);
	}
	
}