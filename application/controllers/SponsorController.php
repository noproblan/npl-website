<?php

class SponsorController extends Zend_Controller_Action
{	
	/**
	 * Redirects to list of sponsors
	 * Access:		Guests, Members
	 */
	public function indexAction()
	{
		return $this->_helper->redirector('list');
	}
	
	/**
	 * List all sponsors
	 * Access:		Guests, Members
	 */
	public function listAction()
	{
		$sponsorMapper = new Application_Model_Mapper_SponsorsMapper();
		$sponsors = $sponsorMapper->fetchAll();
		$this->view->sponsors = $sponsors;
		return;
	}
}