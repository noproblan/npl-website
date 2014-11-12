<?php

class AlbumsController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_albumsModel = new Application_Model_Mapper_AlbumsMapper();
	}

	public function indexAction()
	{
		$albums = $this->_albumsModel->fetchAll();
		$this->view->albums = $albums;
	}

	public function newAction()
	{
		
	}
	
	public function createAction()
	{
		$request = $this->getRequest();
		if ($request->isPost()) {
			$data = $request->getPost();
			$album = new Application_Model_Album();
			$album->setName($data['name']);
			$album->setFolder($data['folder']);
			
			$albums = new Application_Model_Mapper_AlbumsMapper();
			$albums->save($album);
			
			$this->_helper->redirector('index');
		}
	}
}
