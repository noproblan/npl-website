<?php

class Application_Model_Mapper_NewsMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Ungültiges Table Date Gateway angegeben');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_News');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_News $news) {
		$data = array(
			'id' => $news->getId(),
			'author_id' => $news->getAuthorId(),
			'title' => $news->getTitle(),
			'description' => $news->getDescription(),
		);
		
		if (null === ($id = $news->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
	
	public function find($id, Application_Model_News $news) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$this->_setValues($row, $news);
	}

    public function fetchAll()
    {
        return $this->_fetch($this->getDbTable()->fetchAll(null, array('id DESC')));
    }

    public function delete(Application_Model_News $news)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $news->getId());
        $table->delete($where);
    }
	
	protected function _fetch($resultSet)
	{
		$elements = array();
		foreach ($resultSet as $row) {
			$element = new Application_Model_News();
			$this->_setValues($row, $element);
			$elements[] = $element;
		}
		return $elements;
	}
	
	protected function _setValues($row, Application_Model_News $news)
	{
		$news->setId($row->id);
		$news->setAuthorId($row->author_id);
		$news->setTitle($row->title);
		$news->setDescription($row->description);
		$news->setWrittenDatetime($row->written_datetime);
	}
}