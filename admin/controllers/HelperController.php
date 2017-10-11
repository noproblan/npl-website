<?php

class HelperController extends Zend_Controller_Action
{

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


    public function init ()
    {
        $lansModel = new Application_Model_Mapper_LansMapper();
        $this->_upcomingLans = $lansModel->fetchComing();
        $this->_currentLans = $lansModel->fetchCurrent();
    }

    public function indexAction ()
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
                        'username' => $user->getUsername(),
                        'email' => $user->getMail(),
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
                if ($ticket->getHelping() == true) {
                    $user = new Application_Model_User();
                    $usersModel->find($ticket->getUserId(), $user);
                    $ticketsByUser[] = array(
                            'id' => $ticket->getId(),
                            'username' => $user->getUsername(),
                            'email' => $user->getMail(),
                            'status' => $ticket->getStatus()
                    );
                }
            }
            $lanTickets[] = array(
                    'id' => $lan->getId(),
                    'name' => $lan->getName(),
                    'tickets' => $ticketsByUser
            );
        }

        $this->view->lanTickets = $lanTickets;
    }
}

