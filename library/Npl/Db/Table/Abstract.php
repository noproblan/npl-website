<?php

/**
 * @see Zend_Db_Table_Abstract
 */
require_once 'Zend/Db/Table/Abstract.php';

/**
 * 
 * Enter description here ...
 * @author chuvisco
 */
abstract class Npl_Db_Table_Abstract extends Zend_Db_Table_Abstract
{
	protected $_logNameSuffix = "_log";
    
    /**
     * Updates existing rows with logging.
     *
     * @param  array        $data  Column-value pairs.
     * @param  array|string $where An SQL WHERE clause, or an array of SQL WHERE clauses.
     * @return int          The number of rows updated.
     */
    public function update(array $data, $where)
    {
    	$dbName = $this->_name;
    	try {
    		// Do the logging
    		// SELECT
    		$rows = self::fetchAll($where);
    		
    		// INSERT INTO log table
    		$this->_name = $dbName . $this->_logNameSuffix;
    		foreach ($rows as $row) {
    			$result = self::insert($row->toArray());
    		}
    	} catch (Exception $e) {
    		// do nothing
    	}
   		$this->_name = $dbName;
    	return parent::update($data, $where);

    }
    
    /**
     * Delete existing rows with logging.
     *
     * @param  array|string $where An SQL WHERE clause, or an array of SQL WHERE clauses.
     * @return int          The number of rows deleted.
     */
    public function delete($where)
    {
    	$dbName = $this->_name;
    	try {
    		// Do the logging
    		// SELECT
    		$rows = self::fetchAll($where);
    
    		// INSERT INTO log table
    		$this->_name = $dbName . $this->_logNameSuffix;
    		foreach ($rows as $row) {
    			$result = self::insert($row->toArray());
    		}
    	} catch (Exception $e) {
    		// do nothing
    	}
    	$this->_name = $dbName;
    	return parent::delete($where);
    
    }

}
