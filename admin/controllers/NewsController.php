<?php

class NewsController extends Zend_Controller_Action
{
    protected $_flashMessenger = null;
    protected $_instantMessenger = null;

    const MSG_CREATION_SUCCESS   = "Neuer Newseintrag wurde erfolgreich erstellt";
    const MSG_DELETION_SUCCESS   = "Newseintrag wurde erfolgreich gelöscht";
    const MSG_WRONG_PARAM_NEWSID = "Falsche Parameter: Es wurde keine gültige NewsID übergeben";

    public function init()
    {
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->_instantMessenger = new Npl_Helper_InstantMessenger();
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

    public function newAction() {
        $form = new Admin_Form_News_New();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $id = $this->_createNews($form->getValues());
                $this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_CREATION_SUCCESS);
                $this->_helper->redirector('list', 'news');
                return;
            } else {
                foreach ($form->getMessages() as $field => $message) {
                    $label = $form->getElement($field)->getLabel();
                    foreach ($message as $key => $value) {
                        $this->_instantMessenger->addError("<b>" . $label . "</b> " . $value);
                    }
                }
            }
        }
        $this->view->form = $form;
        return;
    }

    public function deleteAction() {
        $newsEntry = new Application_Model_News();
        $news = new Application_Model_Mapper_NewsMapper();

        $id = $this->getRequest()->getParam('id', null);
        if ($id !== null) {
            $news->find((int) $id, $newsEntry);
            $news->delete($newsEntry);
            $this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_DELETION_SUCCESS);
            return $this->_helper->redirector('list');
        } else {
            $this->_flashMessenger->setNamespace('error')->addMessage(self::MSG_WRONG_PARAM_NEWSID);
            return $this->_helper->redirector('list');
        }
    }

    /**
     * Erstelle ein neuer Newseintrag
     * @param string[] $data benötigte Angaben
     * @return int Id, die von der Datenbank zugewiesen wurde
     */
    private function _createNews($data) {
        $news = new Application_Model_News();
        $newsMapper = new Application_Model_Mapper_NewsMapper();
        $auth = Zend_Auth::getInstance();
        $authorId = $auth->getIdentity()->id;

        // create news
        $news->setTitle($data['title']);
        $news->setDescription($data['description']);
        $news->setAuthorId($authorId);

        $newsMapper->save($news);

        return $news->getId();
    }
}

