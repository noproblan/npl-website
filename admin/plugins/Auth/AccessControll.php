<?php

class Admin_Plugin_Auth_AccessControll extends Zend_Controller_Plugin_Abstract
{
	const GUEST_USER_ID = 2;
	protected $_auth;
	protected $_acl;
	
	public function __construct(Zend_Auth $auth, Zend_Acl $acl)
	{
		$this->_auth = $auth;
		$this->_acl = $acl;
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		if ($this->_auth->hasIdentity() && is_object($this->_auth->getIdentity())) {
			$userId = $this->_auth->getIdentity()->id;
		} else {
			$userId = self::GUEST_USER_ID;
		}
		$userrolesMapper = new Admin_Model_Mapper_UserRolesMapper();
		$roleMapper = new Admin_Model_Mapper_RolesMapper();
		$userroles = $userrolesMapper->findByUserId($userId);
		
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		
		$this->_acl->has($controller) == true ? $resource = $controller : $resource = null;
		$privilege = $action;
		
		$allowed = false;
		foreach ($userroles as $userrole) {
			$role = new Admin_Model_Role();
			$roleMapper->find($userrole->getRoleId(), $role);
			if ($this->_acl->isAllowed($role->getName(), $resource, $privilege)) {
				$allowed = true;
			}
		}
		
		if (!$allowed) {
			if ($this->_auth->hasIdentity()) {
				$request->setControllerName('error');
				$request->setActionName('noaccess');
			} else {
				$front = Zend_Controller_Front::getInstance();
				$testRequest = new Zend_Controller_Request_Simple();
				$testRequest->setControllerName($controller);
				$testRequest->setActionName($action);
				
				if (!$front->getDispatcher()->isDispatchable($testRequest)) {
					throw new Zend_Controller_Router_Exception($controller . '/' . $action . ' not found', 404);
				} else {
					$request->setControllerName('auth');
					$request->setActionName('login');
					$request->setParams(array(
						'controller' => $controller,
						'action' => $action,
					));
				}
			}
		}
	}
}