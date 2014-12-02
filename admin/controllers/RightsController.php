<?php

class RightsController extends Zend_Controller_Action
{

    public function init ()
    {
        /* Initialize action controller here */
    }

    public function indexAction ()
    {
        // action body
    }

    public function rolesAction ()
    {
        $this->view->createRoleForm = new Admin_Form_Rights_RoleCreate();
    }

    public function ajaxresourcesAction ()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        /*
         * $user = new Application_Model_DbTable_Users();
         * $users = $user->fetchAll();
         * $dojoData = new Zend_Dojo_Data('id', $users, 'User Listing');
         * echo $dojoData->toJson();
         */
        
        // Creating a sample tree of categories and subcategories
        $a["cat1"]["id"] = "id1";
        $a["cat1"]["name"] = "Category1";
        $a["cat1"]["type"] = "category";
        
        $subcat1 = array(
                "id" => "Subcat1",
                "name" => "Subcategory1",
                "type" => "subcategory"
        );
        $subcat2 = array(
                "id" => "Subcat12",
                "name" => "Subcategory12",
                "type" => "subcategory"
        );
        $a["cat1"]["children"] = array(
                $subcat1,
                $subcat2
        );
        
        $treeObj = new Zend_Dojo_Data('id', $a);
        $treeObj->setLabel('ListOfCategories');
        echo $treeObj->toJson();
    }
}

