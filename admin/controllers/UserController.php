<?php

class UserController extends Zend_Controller_Action
{

    /**
     *
     * @var Application_Model_Mapper_UsersMapper
     */
    protected $_users = null;

    /**
     *
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */
    protected $_flashMessenger = null;

    /**
     *
     * @var Npl_Helper_InstantMessenger
     */
    protected $_instantMessenger = null;

    const MSG_DELETION_FAIL = "User konnte nicht gelöscht werden.";

    const MSG_DELETION_SUCCESS = "User wurde erfolgreich gelöscht";

    const MSG_WRONG_PARAM_USERID = "Falsche Parameter: Es wurde keine gültige UserID übergeben";

    const MSG_CREATION_SUCCESS = "Neuer User wurde erfolgreich erstellt";

    const MSG_NOT_FOUND = "Konnte User nicht finden";

    public function init ()
    {
        // Messengers
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->_instantMessenger = new Npl_Helper_InstantMessenger();
    }

    public function indexAction ()
    {
        $usersModel = new Application_Model_Mapper_UsersMapper();
        $this->view->users = array();
        foreach ($usersModel->fetchAll(null, 'id') as $user) {
            /* @var $user Application_Model_User */
            $this->view->users[] = array(
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'mail' => $user->getMail(),
                    'identified' => $user->getMailVerified(),
                    'active' => $user->getActive(),
                    'registerdate' => $user->getRegisterDatetime()
            );
        }
    }

    public function detailAction ()
    {
        $users = new Application_Model_Mapper_UsersMapper();
        $user = new Application_Model_User();
        
        $id = $this->getRequest()->getParam('id', null);
        
        $this->view->user = array();
        if ($id !== null) {
            $users->find($id, $user);
            $this->view->user['id'] = $user->getId();
            $this->view->user['username'] = $user->getUsername();
            $this->view->user['mail'] = $user->getMail();
        } else {
            $this->_instantMessenger->addError(self::MSG_NOT_FOUND);
        }
    }

    public function newAction ()
    {
        $form = new Admin_Form_User_New();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()
                ->getPost())) {
                $id = $this->_createNewUser($form->getValues());
                $this->_flashMessenger->addMessage(self::MSG_CREATION_SUCCESS);
                $this->_helper->redirector('detail', 'user', null, 
                        array(
                                'id' => $id
                        ));
                return;
            } else {
                foreach ($form->getMessages() as $field => $message) {
                    $label = $form->getElement($field)->getLabel();
                    foreach ($message as $key => $value) {
                        $this->_instantMessenger->addError(
                                "<b>" . $label . "</b> " . $value);
                    }
                }
            }
        }
        $this->view->form = $form;
        return;
    }

    public function deleteAction ()
    {
        $user = new Application_Model_User();
        $users = new Application_Model_Mapper_UsersMapper();
        
        $id = $this->getRequest()->getParam('id', null);
        if ($id !== null) {
            $users->find((int) $id, $user);
            $users->delete($user);
            $this->_instantMessenger->addSuccess(self::MSG_DELETION_SUCCESS);
            return;
        } else {
            $this->_instantMessenger->addError(self::MSG_WRONG_PARAM_USERID);
            return;
        }
        $this->_instantMessenger->addError(self::MSG_DELETION_FAIL);
    }

    public function ajaxdeleteAction ()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $user = new Application_Model_User();
        $users = new Application_Model_Mapper_UsersMapper();
        
        $id = $this->getRequest()->getParam('id', null);
        if ($id !== null) {
            $users->find((int) $id, $user);
            $users->delete($user);
            $this->_flashMessenger->addMessage(self::MSG_DELETION_SUCCESS);
            echo "1";
            return;
        } else {
            $this->_flashMessenger->addMessage(self::MSG_WRONG_PARAM_USERID);
            echo "0";
            return;
        }
        $this->_flashMessenger->addMessage(self::MSG_DELETION_FAIL);
        echo "0";
    }

    public function ajaxlistAction ()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $user = new Application_Model_DbTable_Users();
        $users = $user->fetchAll();
        $dojoData = new Zend_Dojo_Data('id', $users, 'User Listing');
        echo $dojoData->toJson();
    }

    /**
     * Erstelle einen neues Benutzer
     * 
     * @param string[] $data
     *            benötigte Angaben
     * @return int Id, die von der Datenbank zugewiesen wurde
     */
    private function _createNewUser ($data)
    {
        $user = new Application_Model_User();
        $users = new Application_Model_Mapper_UsersMapper();
        
        // create user
        $user->setUsername($data['username']);
        $user->setMail($data['mail']);
        $user->setSalt(
                Application_Model_User::generateSaltFrom($data['username']));
        $user->setPassword(
                Application_Model_User::encryptPassword($data['password'], 
                        Application_Model_User::generateSaltFrom(
                                $data['username'])));
        $user->setActive(true);
        $user->setMailVerified(false);
        $user->setRegisterDateTime(date('Y-m-d h:i:s'));
        $users->save($user);
        
        // give standard roles
        $userrole = new Admin_Model_UserRole();
        $userrole->setRoleId(3); // TODO Standardrole als Magic Number soll weg
        $userrole->setUserId($user->getId());
        
        // save role in DB per Mapper
        $userroles = new Admin_Model_Mapper_UserRolesMapper();
        $userroles->save($userrole);
        
        // TODO aktivieren auf Produktion
        // $user->sendVerificationMail();
        
        return $user->getId();
    }
}

