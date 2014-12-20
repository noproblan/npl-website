<?php

class AuthController extends Zend_Controller_Action
{

    protected $_flashMessenger = null;

    protected $_instantMessenger = null;

    const MSG_ACCOUNT_NOT_ACTIVATED = "Der Account ist noch nicht aktiviert. Bitte prüfe deine Mails.";

    const MSG_FORGOT_PASSWORD = "Passwort vergessen?";

    const MSG_FORGOT_USERNAME = "Benutzername vergessen?";

    const MSG_INVALID_LOGIN_CREDENTIALS = "Die Logindaten sind nicht korrekt.";

    const MSG_RESEND_ACTIVATION = "Aktivierungsmail erneut senden?";

    const URL_RESEND_ACTIVATION = "/user/resendactivation";

    const URL_FORGOT_PASSWORD = "/user/forgotpassword";

    const URL_FORGOT_USERNAME = "/user/forgotusername";

    public function init ()
    {
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->_instantMessenger = new Npl_Helper_InstantMessenger();
    }

    /**
     * Name:        Index
     * Description:    Redirects to login or to user index if logged in
     * Access:        Guests, Members
     */
    public function indexAction ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $this->_helper->redirector('index', 'user');
        } else {
            return $this->_helper->redirector('login', 'auth');
        }
    }

    /**
     * Description:    Allows guests to log in with their credentials.
     * Logged in users are directed.
     * Access:        Guests, Members
     */
    public function loginAction ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $this->_helper->redirector('index', 'user');
        }
        $form = new Application_Form_Login();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()
                ->getPost())) {
                $data = $form->getValues();
                $this->_loginUser($data, null);
            } else {
                $tmpMessages = $form->getMessages();
                foreach ($tmpMessages as $field => $tmpMessage) {
                    $label = $form->getElement($field)->getLabel();
                    foreach ($tmpMessage as $key => $value) {
                        $this->_instantMessenger->addError(
                                "<b>" . $label . "</b> " . $value);
                    }
                }
            }
        }
        $this->view->form = $form;
    }

    /**
     * Name: Logout
     * Description:    Allows members to log off their account
     * Access:        Members
     */
    public function logoutAction ()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_helper->redirector('index', 'index');
    }

    /**
     * Name: loginUser
     * Description:    Authenticate user from data and forward or return messages
     * Access:        Private
     */
    protected function _loginUser ($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $authAdapter = new Application_Plugin_Auth_AuthAdapter();
        $authAdapter->setIdentity($username)->setCredential($password);
        $result = Zend_Auth::getInstance()->authenticate($authAdapter);
        if (! $result->isValid()) {
            $forgotUsername = '<a href="' . self::URL_FORGOT_USERNAME . '">' .
                     self::MSG_FORGOT_USERNAME . '</a>';
            $forgotPassword = '<a href="' . self::URL_FORGOT_PASSWORD . '">' .
                     self::MSG_FORGOT_PASSWORD . '</a>';
            $this->_instantMessenger->addError(
                    self::MSG_INVALID_LOGIN_CREDENTIALS);
            $this->_instantMessenger->addNotice(
                    $forgotUsername . " - " . $forgotPassword);
        } else {
            $storage = Zend_Auth::getInstance()->getStorage();
            $storage->write($authAdapter->getResultRowObject(null, 'password'));
            $user = new Application_Model_User();
            $users = new Application_Model_Mapper_UsersMapper();
            $users->find(Zend_Auth::getInstance()->getIdentity()->id, $user);
            if (! $user->getActive()) {
                $storage->clear();
                $resendUrl = self::URL_RESEND_ACTIVATION . '/id/' .
                         $user->getId() . '/key/' . $user->getSalt();
                $this->_instantMessenger->addNotice(
                        self::MSG_ACCOUNT_NOT_ACTIVATED . "<br />" . '<a href="' .
                                 $resendUrl . '">' . self::MSG_RESEND_ACTIVATION .
                                 '</a>');
            } else {
                $controller = $this->getRequest()->getParam('controller', 
                        'user');
                $action = $this->getRequest()->getParam('action', 'index');
                $action == 'login' ? $action = 'index' : $action;
                $sentParameters = $this->getRequest()->getParams();
                $params = array();
                foreach ($sentParameters as $key => $value) {
                    if ($key != 'controller' && $key != 'action' &&
                             $key != 'module' && $key != 'username' &&
                             $key != 'password') {
                        $params[$key] = $value;
                    }
                }
                return $this->_helper->redirector($action, $controller, 
                        'default', $params);
            }
        }
    }
}