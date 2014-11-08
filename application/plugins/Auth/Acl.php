<?php

class Application_Plugin_Auth_Acl extends Zend_Acl
{	
	public function __construct()
	{
		self::initResources();
		self::initRoles();
		self::initRights();
	}
	
	private function initResources()
	{
		$mapper = new Application_Model_Mapper_ResourcesMapper();
		$resources = $mapper->fetchResources();
		
		foreach ($resources as $resource) {
			$this->addResource(new Zend_Acl_Resource($resource->getControllerName()));
		}
	}
	
	private function initRoles()
	{
		$mapper = new Application_Model_Mapper_RolesMapper();
		$roles = $mapper->fetchAll();
		
		foreach ($roles as $role) {
			$this->addRole(new Zend_Acl_Role($role->getName()));
		}
	}
	
	private function initRights()
	{
		$mapperResources = new Application_Model_Mapper_ResourcesMapper();
		$mapperRights = new Application_Model_Mapper_RightsMapper();
		$mapperRoles = new Application_Model_Mapper_RolesMapper();
		$rights = $mapperRights->fetchAll();
		
		foreach ($rights as $right) {
			$resource = new Application_Model_Resource();
			$role = new Application_Model_Role();
			$mapperResources->find($right->getResourceId(), $resource);
			$mapperRoles->find($right->getRoleId(), $role);
			$this->allow($role->getName(), $resource->getControllerName(), $resource->getActionName());
		}
		
		// Allow everthing to administrator except login (Login not needed 'cause of already logged in)
		$this->allow('Administrator');
		$this->deny('Administrator', 'auth', 'login');
		
		// Allow Error-Controller (all Actions) for everyone
		$this->allow(null, 'error');
	}
}