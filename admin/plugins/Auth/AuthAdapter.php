<?php

class Admin_Plugin_Auth_AuthAdapter extends Zend_Auth_Adapter_DbTable
{
	public function __construct() {
		parent::__construct(Zend_Registry::get('db'));
		$this->setTableName('npl_users')
			->setIdentityColumn('username')
			->setCredentialColumn('password')
			->setCredentialTreatment('SHA1(CONCAT(?, salt)) ');
	}
}