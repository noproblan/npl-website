<?php

class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract
{
	public function loggedInAs()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$username = $auth->getIdentity()->username;
			$profilUrl = $this->view->url(
				array(
					'controller' => 'user',
					'action' => 'account',
				), 
				'default', 
				true);
			$logoutUrl = $this->view->url(
				array(
					'controller' => 'auth',
					'action' => 'logout',
				),
				'default',
				true);
			$html = 'Willkommen <a href="' . $profilUrl . '">' . $username . '</a> | <a href="' . $logoutUrl . '">Logout</a>';
			return $html;
		}
		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		if ($controller == 'auth' && $action == 'index') {
			return '';
		}
		$loginUrl = $this->view->url(
			array(
				'controller' => 'auth',
				'action' => 'login',
			),
			'default', 
			true);
		$registerUrl = $this->view->url(
			array(
				'controller' => 'user',
				'action' => 'register',
			), 
			'default', 
			true);
		$html = '<a href="' . $loginUrl . '">Login</a> | <a href="' . $registerUrl . '">Registrieren</a>';
		return $html;
	}
}