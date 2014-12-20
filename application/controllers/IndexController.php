<?php

class IndexController extends Zend_Controller_Action
{

    public function init ()
    {
        /* Initialize action controller here */
    }

    public function indexAction ()
    {
        return $this->_forward('list', 'news');
    }

    public function aboutAction ()
    {}

    public function contactAction ()
    {}
}

