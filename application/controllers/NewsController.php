<?php

class NewsController extends Zend_Controller_Action
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
        Zend_Paginator::setDefaultItemCountPerPage(5);

        $newsMapper = new Application_Model_Mapper_NewsMapper();
        $news = $newsMapper->fetchAll();
        $paginator = Zend_Paginator::factory($news);

        $page = $this->getRequest()->getParam('page', 1);
        if (!is_numeric($page) || $page < 1) {
            $page = 1;
        } else {
            $page = (int) $page;
        }

        $paginator->setCurrentPageNumber($page);
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial(
            'partials/paginator/controls.phtml'
        );

        $this->view->paginator = $paginator;

        return;
    }
    
    public function entryAction() {
    	
    }
}

