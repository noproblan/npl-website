<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        return $this->_helper->redirector('list');
    }
    
    public function listAction() {
        $newsMapper = new Application_Model_Mapper_NewsMapper();
        $news = $newsMapper->fetchAll();
        $this->view->news = Zend_Paginator::factory($news);;
        return;
    }
    
    public function entryAction() {
    	
    }
}

