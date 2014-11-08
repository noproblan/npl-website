<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initSaltWort()
	{
		Zend_Registry::set('saltword', '@noproblan');
	}

	protected function _initMail()
	{
		$resource = $this->getPluginResource('mail');
		$options = $resource->getOptions();
		$transport = $options['transport'];
		$defaultFrom = $options['defaultFrom'];
		$defaultReplyTo = $options['defaultReplyTo'];

		$host = isset($transport['host']) ? $transport['host'] : '';
		$port = isset($transport['port']) ? $transport['port'] : '';
		$auth = isset($transport['auth']) ? $transport['auth'] : '';
		$username = isset($transport['username']) ? $transport['username'] : '';
		$password = isset($transport['password']) ? $transport['password'] : '';

		$fromMail = isset($defaultFrom['email']) ? $defaultFrom['email'] : '';
		$fromName = isset($defaultFrom['name']) ? $defaultFrom['name'] : '';
		$replyMail = isset($defaultReplyTo['email']) ? $defaultReplyTo['email'] : '';
		$replyName = isset($defaultReplyTo['name']) ? $defaultReplyTo['name'] : '';

		$config = array(
			'port' => $port,
			'auth' => $auth,
			'username' => $username,
			'password' => $password,
		);

		$tr = new Zend_Mail_Transport_Smtp($host, $config);
		Zend_Mail::setDefaultTransport($tr);
		Zend_Mail::setDefaultFrom($fromMail, $fromName);
		Zend_Mail::setDefaultReplyTo($replyMail, $replyName);
	}

	protected function _initDb()
	{
		// Write DbAdapter into Registry
		$resource = $this->getPluginResource('db');
		$dbAdapter = $resource->getDbAdapter();

		Npl_Db_Table_Abstract::setDefaultAdapter($dbAdapter);

		Zend_Registry::set('db', $dbAdapter);
	}

	protected function _initInstantMessenger()
	{
		if (!Zend_Registry::isRegistered('InstantMessenger')) {
			Zend_Registry::set('InstantMessenger', array('error' => array(), 'notice' => array(), 'success' => array()));
		}
	}
	
	protected function _initView()
	{
		$options = $this->getOptions();
		if (isset($options['resources']['view'])) {
			$view = new Zend_View($options['resources']['view']);
		} else {
			$view = new Zend_View;
		}
		if (isset($options['resources']['view']['doctype'])) {
			$view->doctype($options['resources']['view']['doctype']);
		}
		if (isset($options['resources']['view']['title'])) {
			$view->headTitle($options['resources']['view']['title']);
		}
		if (isset($options['resources']['view']['contentType'])) {
			$view->headMeta()->appendHttpEquiv('Content-Type', $options['resources']['view']['contentType']);
		}
		
		// add Dojo helpers
		$view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper'); 
				
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);
		return $view;
	}

	protected function _initAuth()
	{
		$this->bootstrap('frontController');
		$auth = Zend_Auth::getInstance();
		$acl = new Admin_Plugin_Auth_Acl();
		$this->getResource('frontController')->registerPlugin(new Admin_Plugin_Auth_AccessControll($auth, $acl))->setParam('auth', $auth);
	}

}
