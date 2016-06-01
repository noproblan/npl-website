<?php

class LanController extends Zend_Controller_Action
{

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

    /**
     *
     * @var Application_Model_Lan[]
     */
    private $_upcomingLans = null;

    /**
     *
     * @var Application_Model_Lan[]
     */
    private $_currentLans = null;

    const MSG_CREATION_SUCCESS = "Neues Ticket wurde erfolgreich erstellt";

    public function init ()
    {
        // Messengers
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->_instantMessenger = new Npl_Helper_InstantMessenger();
        
        $lansModel = new Application_Model_Mapper_LansMapper();
        $this->_upcomingLans = $lansModel->fetchComing();
        $this->_currentLans = $lansModel->fetchCurrent();
        $this->_helper->ajaxContext()
            ->addActionContext('ajaxticket', 'json')
            ->initContext();
    }

    public function indexAction ()
    {
        $this->view->upcomingLans = $this->_upcomingLans;
    }

    public function ticketsAction ()
    {
        $usersModel = new Application_Model_Mapper_UsersMapper();
        $ticketsModel = new Application_Model_Mapper_TicketsMapper();
        
        $lanTickets = array();
        foreach ($this->_currentLans as $lan) {
            /* @var $lan Application_Model_Lan */
            $tickets = $ticketsModel->fetchAllByLanId($lan->getId());
            $ticketsByUser = array();
            foreach ($tickets as $ticket) {
                /* @var $ticket Application_Model_Ticket */
                $user = new Application_Model_User();
                $usersModel->find($ticket->getUserId(), $user);
                $ticketsByUser[] = array(
                        'id' => $ticket->getId(),
                        'userid' => $user->getId(),
                        'username' => $user->getUsername(),
                        'email' => $user->getMail(),
                        'extras' => $ticket->getExtras(),
                        'bill' => $this->_getCalculatedExtras(
                                $ticket->getExtrasSplitted()),
                        'status' => $ticket->getStatus()
                );
            }
            $lanTickets[] = array(
                    'id' => $lan->getId(),
                    'name' => $lan->getName(),
                    'tickets' => $ticketsByUser
            );
        }
        foreach ($this->_upcomingLans as $lan) {
            /* @var $lan Application_Model_Lan */
            $tickets = $ticketsModel->fetchAllByLanId($lan->getId());
            $ticketsByUser = array();
            foreach ($tickets as $ticket) {
                /* @var $ticket Application_Model_Ticket */
                $user = new Application_Model_User();
                $usersModel->find($ticket->getUserId(), $user);
                $ticketsByUser[] = array(
                        'id' => $ticket->getId(),
                        'userid' => $user->getId(),
                        'username' => $user->getUsername(),
                        'email' => $user->getMail(),
                        'extras' => $ticket->getExtras(),
                        'bill' => $this->_getCalculatedExtras(
                                $ticket->getExtrasSplitted()),
                        'status' => $ticket->getStatus()
                );
            }
            $lanTickets[] = array(
                    'id' => $lan->getId(),
                    'name' => $lan->getName(),
                    'tickets' => $ticketsByUser
            );
        }
        
        $this->view->lanTickets = $lanTickets;
    }

    public function newticketAction ()
    {
        $form = new Admin_Form_Ticket_New();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()
                ->getPost())) {
                $id = $this->_createNewTicket($form->getValues());
                $this->_flashMessenger->setNamespace('success')->addMessage(
                        self::MSG_CREATION_SUCCESS);
                $this->_helper->redirector('newticket', 'lan');
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

    public function ajaxticketAction ()
    {
        // Ticketstatus ändern
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
        $ticketid = $this->getRequest()->getParam('id', null);
        $newStatus = $this->getRequest()->getParam('newstatus', null);
        if (isset($newStatus) && is_numeric($ticketid)) {
            $ticketid = (int) $ticketid;
            $ticketsModel = new Application_Model_Mapper_TicketsMapper();
            $ticket = new Application_Model_Ticket();
            $ticketsModel->find($ticketid, $ticket);
            $ticket->setStatus($newStatus);
            $ticketsModel->save($ticket);
            if ($newStatus == 'prepaid') {
                $this->_sendPrepaidMail($ticket);
            }
            $answer = $ticket->getId();
        } else {
            $this->getResponse()->setHttpResponseCode(400);
            $answer = - 1;
        }
        echo json_encode($answer);
    }

    public function ajaxextrasAction()
    {
        // Ändern von Ticketextras
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
        $ticketId = $this->getRequest()->getParam('id', null);
        $newExtras = $this->getRequest()->getParam('newextras', null);
        if (isset($newExtras) && is_numeric($ticketId)) {
            try {
                $newExtras = $this->_mapExtras($newExtras);
                $ticketId = (int) $ticketId;
                $ticketsModel = new Application_Model_Mapper_TicketsMapper();
                $ticket = new Application_Model_Ticket();
                $ticketsModel->find($ticketId, $ticket);
                $ticket->setExtras($newExtras);
                $ticketsModel->save($ticket);
                $answer = array(
                    'success' => 'true',
                    'ticket_id' => $ticket->getId(),
                    'extras' => $ticket->getExtras(),
                    'mapped_extras' => $this->_mapExtras($ticket->getExtras()),
                    'updated_price' => $this->_getCalculatedExtras($ticket->getExtrasSplitted()),
                );
            } catch (UnexpectedValueException $e) {
                $this->getResponse()->setHttpResponseCode(400);
                $answer = -1;
            }
        } else {
            $this->getResponse()->setHttpResponseCode(400);
            $answer = -1;
        }
        echo json_encode($answer);
    }

    private function _mapExtras($extra)
    {
        $map = array(
            'none'              => 'none',
            'breakfast'         => 'breakfast',
            'dinner'            => 'dinner',
            'both'              => 'breakfast,dinner',
            'breakfast,dinner'  => 'both'
        );

        if (!array_key_exists($extra, $map)) {
            throw new UnexpectedValueException($extra . ' not found in map');
        }

        return $map[$extra];
    }

    private function _getCalculatedExtras ($extrasArray)
    {
        $result = 40;
        if (isset($extrasArray['breakfast']))
            $result += 5;
        if (isset($extrasArray['dinner']))
            $result += 15;
        if (isset($extrasArray['cable']))
            $result += 10;
        return $result;
    }

    private function _sendPrepaidMail (Application_Model_Ticket $ticket)
    {
        $usersModel = new Application_Model_Mapper_UsersMapper();
        $user = new Application_Model_User();
        $usersModel->find($ticket->getUserId(), $user);
        $lansModel = new Application_Model_Mapper_LansMapper();
        $lan = new Application_Model_Lan();
        $lansModel->find($ticket->getLanId(), $lan);
        
        $mail = new Npl_Mail("utf-8");
        $mail->setRecipient($user->getMail(), $user->getUsername());
        $mail->setTemplate("prepaid");
        $mail->setTemplatePath(APPLICATION_PATH . "/views/scripts/mails");
        $mail->ticketnr = $ticket->getId();
        $mail->username = $user->getUsername();
        $mail->lanname = $lan->getName();
        $mail->lanstart = $lan->getStartDatetime();
        try {
            $mail->send();
            $this->_flashMessenger->setNamespace('success')->addMessage(
                    'Eine E-Mail zur Bestätigung der Vorauszahlung wurde verschickt.');
        } catch (Zend_Mail_Transport_Exception $e) {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                    'Die Bestätigung der Vorauszahlung konnte nicht an ' .
                             $user->getUsername() . ' (' . $user->getMail() .
                             ') versendet werden.');
        }
    }

    /**
     * Erstelle ein neues Ticket
     * 
     * @param string[] $data
     *            benötigte Angaben
     * @return int Id, die von der Datenbank zugewiesen wurde
     */
    private function _createNewTicket ($data)
    {
        $ticket = new Application_Model_Ticket();
        $ticketMapper = new Application_Model_Mapper_TicketsMapper();
        
        // create ticket
        $ticket->setLanId($data['lans']);
        $ticket->setUserId($data['users']);
        $ticket->setStatus(Application_Model_Ticket::STATUS_NOTPAID);
        switch ($data['extras']) {
            case 'none':
                $ticket->setExtras('');
                break;
            case 'breakfast':
                $ticket->setExtras('breakfast');
                break;
            case 'dinner':
                $ticket->setExtras('dinner');
                break;
            case 'both':
            default:
                $ticket->setExtras('breakfast,dinner');
        }
        
        switch ($data['status']) {
            case 'prepaid':
                $ticket->setStatus(Application_Model_Ticket::STATUS_PREPAID);
                break;
            case 'paid':
                $ticket->setStatus(Application_Model_Ticket::STATUS_PAID);
                break;
            case 'notpaid':
            default:
                $ticket->setStatus(Application_Model_Ticket::STATUS_NOTPAID);
        }
        
        $ticketMapper->save($ticket);
        
        return $ticket->getId();
    }
}

