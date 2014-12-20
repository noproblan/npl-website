<?php

class LanController extends Zend_Controller_Action
{

    /**
     * Mapper instance of lans.
     * 
     * @var Application_Model_Mapper_LansMapper
     */
    protected $_mapperLans = null;

    /**
     * Mapper instance of laninfos.
     * 
     * @var Application_Model_Mapper_LaninfosMapper
     */
    protected $_mapperLaninfos = null;

    /**
     * Mapper instance of users.
     * 
     * @var Application_Model_Mapper_UsersMapper
     */
    protected $_mapperUsers = null;

    /**
     * Current user.
     * 
     * @var Application_Model_currentUser
     */
    protected $_currentUser = null;

    /**
     *
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */
    protected $_flashMessenger = null;

    /**
     * Helper instance
     * 
     * @var Npl_Helper_InstantMessenger
     */
    protected $_instantMessenger = null;

    /**
     * Filter instance for stripping tags
     * 
     * @var Zend_Filter_StripTags
     */
    protected $_stripFilter = null;

    /**
     * Validator instance for digits.
     * 
     * @var Zend_Validate_Digits
     */
    protected $_digitValidator = null;

    /**
     * Validator instance for ids of lans.
     * 
     * @var Zend_Validate_Db_RecordExists
     */
    protected $_lanIDValidator = null;

    const MSG_LANID_INVALID = "Die angegebene LAN ID ist ungültig.";

    const MSG_REQUEST_INVALID = "Die Anfrage ist ungültig.";

    const MSG_NO_TICKET = "Du bist nicht zu dieser LAN angemeldet.";

    const MSG_NOT_PAID = "Du hast noch nicht bezahlt.";

    /**
     *
     * @see Zend_Controller_Action::init()
     */
    public function init ()
    {
        $this->_mapperLans = new Application_Model_Mapper_LansMapper();
        $this->_mapperLaninfos = new Application_Model_Mapper_LaninfosMapper();
        $this->_mapperUsers = new Application_Model_Mapper_UsersMapper();
        $this->_currentUser = new Application_Model_User();
        
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_mapperUsers->find(
                    Zend_Auth::getInstance()->getIdentity()->id, 
                    $this->_currentUser);
        }
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->_instantMessenger = new Npl_Helper_InstantMessenger();
        
        $this->_stripFilter = new Zend_Filter_StripTags();
        
        $this->_digitValidator = new Zend_Validate_Digits();
        $this->_lanIDValidator = new Zend_Validate_Db_RecordExists(
                array(
                        'table' => 'npl_lans',
                        'field' => 'id'
                ));
    }

    /**
     * Description:    Redirects to list of lans.
     * Access:        Guests, Members
     */
    public function indexAction ()
    {
        return $this->_helper->redirector('list');
    }

    /**
     * Description:    List all coming lans.
     * Access:        Guests, Members
     */
    public function listAction ()
    {
        $lans = new Application_Model_Mapper_LansMapper();
        $currentLans = $lans->fetchCurrent();
        $comingLans = $lans->fetchComing();
        $passedLans = $lans->fetchPassed();
        $this->view->currentLans = $currentLans;
        $this->view->comingLans = $comingLans;
        $this->view->passedLans = $passedLans;
        return;
    }

    /**
     * Description:    Shows all detailed info about the lan.
     * Access:        Guests, Members
     */
    public function infoAction ()
    {
        $lanId = $this->getRequest()->getParam('lanid', null);
        if ($lanId != null) {
            $lanId = $this->_stripFilter->filter($lanId);
            if ($this->_digitValidator->isValid($lanId) &&
                     $this->_lanIDValidator->isValid($lanId)) {
                $mapperTickets = new Application_Model_Mapper_TicketsMapper();
                $tickets = $mapperTickets->fetchAllByLanAndUserId($lanId, 
                        $this->_currentUser->getId());
                $this->view->hasTicket = $this->_currentUser->hasTicketOfLan(
                        $lanId);
                // TODO: Anpassen für mehrere Tickets
                $hasPaid = false;
                if (! empty($tickets)) {
                    if ($tickets[0]->getStatus() ==
                             Application_Model_Ticket::STATUS_PAID ||
                             $tickets[0]->getStatus() ==
                             Application_Model_Ticket::STATUS_PREPAID) {
                        $hasPaid = true;
                    }
                }
                $this->view->hasPaid = $hasPaid;
                $this->view->userTickets = $tickets;
                
                $lan = new Application_Model_Lan();
                $laninfos = new Application_Model_Laninfo();
                
                $this->_mapperLans->find($lanId, $lan);
                $this->view->lan = $lan;
                
                $infos = $this->_mapperLaninfos->fetchByLanId($lanId);
                $this->view->infos = $infos;
                
                $participants = $lan->getParticipants();
                $this->view->participants = $participants;
                return;
            } else {
                return $this->_instantMessenger->addError(
                        self::MSG_LANID_INVALID);
            }
        } else {
            return $this->_instantMessenger->addError(self::MSG_LANID_INVALID);
        }
        return $this->_instantMessenger->addError(self::MSG_REQUEST_INVALID);
    }

    /**
     * Description:    Checks if user has a ticket and redirect to seatreservation
     * or to shop.
     * Access:        Guests, Members
     */
    public function participateAction ()
    {
        $lanId = $this->getRequest()->getParam('lanid', null);
        $prevController = $this->getRequest()->getParam('prevcont', null);
        $participate = $this->getRequest()->getParam('participate', 'yes');
        if ($lanId != null) {
            $lanId = $this->_stripFilter->filter($lanId);
            $participate = $this->_stripFilter->filter($participate);
            if ($this->_digitValidator->isValid($lanId) &&
                     $this->_lanIDValidator->isValid($lanId)) {
                if ($this->_currentUser->hasTicketOfLan($lanId)) {
                    if ($participate == 'no') {
                        $ticketMapper = new Application_Model_Mapper_TicketsMapper();
                        $tickets = $ticketMapper->fetchAllByLanAndUserId($lanId, 
                                $this->_currentUser->getId());
                        foreach ($tickets as $ticket) {
                            if ($ticket->getStatus() == 'notpaid') {
                                $ticketMapper->delete($ticket);
                                $this->_flashMessenger->setNamespace('success')->addMessage(
                                        'Du wurdest von der LAN abgemeldet.');
                            } else {
                                $this->_flashMessenger->setNamespace('notice')->addMessage(
                                        'Du kannst dich nicht abmelden, da du bereits bezahlt hast.');
                            }
                        }
                        if ($prevController == 'lan') {
                            return $this->_helper->redirector('info', 'lan', 
                                    'default', array(
                                            'lanid' => $lanId
                                    ));
                        }
                        return $this->_helper->redirector('account', 'user');
                    }
                    $this->_flashMessenger->setNamespace('notice')->addMessage(
                            'Du bist bereits zur LAN angemeldet');
                    if ($prevController == 'lan') {
                        return $this->_helper->redirector('info', 'lan', 
                                'default', array(
                                        'lanid' => $lanId
                                ));
                    }
                    return $this->_helper->redirector('account', 'user');
                    // return $this->_helper->redirector('reservation', 'lan',
                // 'default', array('lanid' => $lanId));
                } else {
                    $ticket = new Application_Model_Ticket();
                    $ticketMapper = new Application_Model_Mapper_TicketsMapper();
                    $ticket->setLanId($lanId);
                    $ticket->setUserId($this->_currentUser->getId());
                    $ticketMapper->save($ticket);
                    $this->_flashMessenger->setNamespace('success')->addMessage(
                            'Du wurdest zur LAN angemeldet');
                    if ($prevController == 'lan') {
                        return $this->_helper->redirector('info', 'lan', 
                                'default', array(
                                        'lanid' => $lanId
                                ));
                    }
                    return $this->_helper->redirector('account', 'user');
                    // return $this->_helper->redirector('index', 'shop');
                }
            } else {
                $this->_flashMessenger->setNamespace('error')->addMessage(
                        self::MSG_LANID_INVALID);
                if ($prevController == 'lan') {
                    return $this->_helper->redirector('list');
                }
                return $this->_helper->redirector('account', 'user');
            }
        } else {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                    self::MSG_LANID_INVALID);
            if ($prevController == 'lan') {
                return $this->_helper->redirector('list');
            }
            return $this->_helper->redirector('account', 'user');
        }
        $this->_flashMessenger->setNamespace('error')->addMessage(
                self::MSG_REQUEST_INVALID);
        if ($prevController == 'lan') {
            return $this->_helper->redirector('list');
        }
        return $this->_helper->redirector('account', 'user');
    }

    /**
     * Description:    Shows seatreservation
     * Access:        Members
     */
    public function reservationAction ()
    {
        $lanId = $this->getRequest()->getParam('lanid', null);
        if ($lanId != null) {
            $lanId = $this->_stripFilter->filter($lanId);
            if ($this->_digitValidator->isValid($lanId) &&
                     $this->_lanIDValidator->isValid($lanId)) {
                if ($this->_currentUser->hasTicketOfLan($lanId)) {
                    $mapperTickets = new Application_Model_Mapper_TicketsMapper();
                    $tickets = $mapperTickets->fetchAllByLanAndUserId($lanId, 
                            $this->_currentUser->getId());
                    // TODO: Erweitern für alle Tickets
                    if ($tickets[0]->getStatus() !=
                             Application_Model_Ticket::STATUS_NOTPAID) {
                        $ticketId = $tickets[0];
                        $lan = new Application_Model_Lan();
                        $this->_mapperLans->find($lanId, $lan);
                        $mapperMaps = new Application_Model_Mapper_MapsMapper();
                        $mapperDesks = new Application_Model_Mapper_DesksMapper();
                        $maps = $mapperMaps->fetchAllByLanId($lanId);
                        $map = $maps[0];
                        $desks = array();
                        foreach ($maps as $map) {
                            $desks = $mapperDesks->fetchAllByMapId(
                                    $map->getId());
                        }
                        $this->view->currentSeatId = $tickets[0]->getSeatId();
                        $this->view->userSeats = array();
                        foreach ($mapperTickets->fetchAllByLanId($lanId) as $ticket) { /* @var $ticket Application_Model_Ticket */
                            $user = new Application_Model_User();
                            $this->_mapperUsers->find($ticket->getUserId(), 
                                    $user);
                            $seatId = $ticket->getSeatId();
                            if (! empty($seatId)) {
                                $this->view->userSeats[$seatId] = array(
                                        "userid" => $user->getId(),
                                        "username" => $user->getUsername(),
                                        "seatid" => $ticket->getSeatId()
                                );
                            }
                        }
                        $this->view->ticket = $ticketId;
                        $this->view->lan = $lan;
                        $this->view->maps = $map;
                        $this->view->desks = $desks;
                        return;
                    } else {
                        $this->_flashMessenger->setNamespace('notice')->addMessage(
                                self::MSG_NOT_PAID);
                        return $this->_helper->redirector('info', 'lan', null, 
                                array(
                                        'lanid' => $lanId
                                ));
                    }
                } else {
                    $this->_flashMessenger->setNamespace('notice')->addMessage(
                            self::MSG_NO_TICKET);
                    return $this->_helper->redirector('info', 'lan', null, 
                            array(
                                    'lanid' => $lanId
                            ));
                }
            } else {
                $this->_flashMessenger->setNamespace('error')->addMessage(
                        self::MSG_LANID_INVALID);
                return $this->_helper->redirector('list', 'lan');
            }
        } else {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                    self::MSG_LANID_INVALID);
            return $this->_helper->redirector('list', 'lan');
        }
    }

    /**
     * Description:    Generates the maps of a given lan.
     * Access:        Private
     */
    // TODO: Extract into Lan-Model
    protected function _generateMaps ($lanId)
    {
        $html = "";
        $mapsMapper = new Application_Model_Mapper_MapsMapper();
        $desksMapper = new Application_Model_Mapper_DesksMapper();
        $seatsMapper = new Application_Model_Mapper_SeatsMapper();
        $maps = $mapsMapper->fetchAllByLanId($lanId);
        foreach ($maps as $map) {
            $html .= $map->generatePicture();
            $desks = $desksMapper->fetchAllByMapId($map->getId());
            foreach ($desks as $desk) {
                $html .= $desk->generatePicture();
                $seats = $seatsMapper->fetchAllByDeskId($desk->getId());
            }
        }
        return $html;
    }
}