<?php

use Sprain\SwissQrBill as QrBill;

class TicketController extends Zend_Controller_Action
{

    /**
     * Mapper instance of tickets.
     *
     * @var Application_Model_Mapper_TicketsMapper
     */
    protected $_mapperTickets = null;

    /**
     * Mapper instance of users.
     *
     * @var Application_Model_Mapper_UsersMapper
     */
    protected $_mapperUsers = null;

    /**
     * Current user.
     *
     * @var Application_Model_User
     */
    protected $_currentUser = null;

    /**
     *
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */
    protected $_flashMessenger = null;

    /**
     * Validator instance for digits.
     *
     * @var Zend_Validate_Digits
     */
    protected $_digitValidator = null;

    /**
     * Validator instance for ids of tickets.
     *
     * @var Zend_Validate_Db_RecordExists
     */
    protected $_ticketIDValidator = null;

    /**
     * Validator instance for ids of seats.
     *
     * @var Zend_Validate_Db_RecordExists
     */
    protected $_seatIDValidator = null;

    const MSG_TICKETID_INVALID = "Die angegebene Ticket ID ist ungültig.";

    const MSG_SEATID_INVALID = "Die angegebene Seat ID ist ungültig.";

    const MSG_REQUEST_INVALID = "Die Anfrage ist ungültig.";

    const MSG_ONLY_PAID = "Die Sitzplatzreservation ist nur bei (voraus)bezahltem Eintritt verfügbar.";

    const MSG_SEAT_TAKEN = "Der Sitzplatz ist bereits besetzt.";

    const MSG_SEAT_RESERVED = "Der Sitzplatz wurde erfolgreich reserviert.";

    /**
     *
     * @see Zend_Controller_Action::init()
     */
    public function init ()
    {
        $this->_mapperTickets = new Application_Model_Mapper_TicketsMapper();
        $this->_mapperUsers = new Application_Model_Mapper_UsersMapper();
        $this->_currentUser = new Application_Model_User();

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_mapperUsers->find(
                    Zend_Auth::getInstance()->getIdentity()->id,
                    $this->_currentUser);
        }

        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');

        $this->_digitValidator = new Zend_Validate_Digits();
        $this->_ticketIDValidator = new Zend_Validate_Db_RecordExists(
                array(
                        'table' => 'npl_srs_tickets',
                        'field' => 'id'
                ));
        $this->_seatIDValidator = new Zend_Validate_Db_RecordExists(
                array(
                        'table' => 'npl_srs_seats',
                        'field' => 'id'
                ));
    }

    /**
     * Description:    Sets extras to given extras from ticketextras form.
     * Access:        Members
     */
    public function changeextrasAction ()
    {
        $form = new Application_Form_TicketExtras();

        if (! $this->getRequest()->isPost())
            return $this->_helper->redirector('list', 'lan');
        if (! $form->isValid($this->getRequest()
            ->getPost()))
            return $this->_helper->redirector('list', 'lan');
        if (! $this->_digitValidator->isValid($form->getValue('ticketId')))
            return $this->_helper->redirector('list', 'lan');
        if (! $this->_ticketIDValidator->isValid($form->getValue('ticketId')))
            return $this->_helper->redirector('list', 'lan');

        $ticketId = (int) $form->getValue('ticketId');

        $ticket = new Application_Model_Ticket();
        $this->_mapperTickets->find($ticketId, $ticket);

        if ($this->_currentUser->getId() != $ticket->getUserId())
            return $this->_helper->redirector('list', 'lan');

        $extras = array();
        $hasHelpingStatusChanged = false;
        foreach ($form->getValues() as $key => $value) {
            if ($key != "ticketId" && $key != "submit" && $key != "helping") {
                if ($value == "1") {
                    $value = true;
                    $extras[$key] = $value;
                } elseif ($value == "0") {
                    $value = false;
                    $extras[$key] = $value;
                }
            } elseif ($key == "helping") {
                $hasHelpingStatusChanged = $ticket->getHelping() != $value;
                $ticket->setHelping($value == "1");
            }
        }

        $ticket->setExtrasSplitted($extras);
        $this->_mapperTickets->save($ticket);

        if ($hasHelpingStatusChanged) {
            $this->sendHelpingMail($ticket);
        }

        $this->_flashMessenger->setNamespace('success')->addMessage(
                'Die Optionen für die LAN wurden gespeichert.'); //
        return $this->_helper->redirector('account', 'user');
    }

    /**
     * Description:    Reserves a given seat if possible
     * Access:        Members
     */
    public function reserveseatAction ()
    {
        if (! $this->getRequest()->isPost())
            return $this->_helper->redirector('list', 'lan');

        $ticketId = $this->getRequest()->getParam('ticket', null);
        $seatId = $this->getRequest()->getParam('seat', null);

        if (is_null($ticketId) || is_null($seatId))
            return $this->_helper->redirector('list', 'lan');
        if (! $this->_digitValidator->isValid($ticketId) ||
                 ! $this->_digitValidator->isValid($seatId)) {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                    self::MSG_REQUEST_INVALID);
            return $this->_helper->redirector('list', 'lan');
        }
        if (! $this->_ticketIDValidator->isValid($ticketId)) {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                    self::MSG_TICKETID_INVALID);
            return $this->_helper->redirector('list', 'lan');
        }

        $ticketsMapper = new Application_Model_Mapper_TicketsMapper();
        $ticket = new Application_Model_Ticket();
        $ticketsMapper->find($ticketId, $ticket);

        if (! $this->_seatIDValidator->isValid($seatId)) {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                    self::MSG_SEATID_INVALID);
            return $this->_helper->redirector('reservation', 'lan', null,
                    array(
                            'lanid' => $ticket->getLanId()
                    ));
        }

        if ($ticket->getStatus() == Application_Model_Ticket::STATUS_NOTPAID) {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                    self::MSG_ONLY_PAID);
            return $this->_helper->redirector('reservation', 'lan', null,
                    array(
                            'lanid' => $ticket->getLanId()
                    ));
        }

        $seatsMapper = new Application_Model_Mapper_SeatsMapper();
        $seat = new Application_Model_Seat();
        $seatsMapper->find($seatId, $seat);

        if (! $seat->isAvailable()) {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                    self::MSG_SEAT_TAKEN);
            return $this->_helper->redirector('reservation', 'lan', null,
                    array(
                            'lanid' => $ticket->getLanId()
                    ));
        }

        $ticket->setSeatId($seatId);
        $ticketsMapper->save($ticket);
        $this->_flashMessenger->setNamespace('success')->addMessage(
                self::MSG_SEAT_RESERVED);
        return $this->_helper->redirector('reservation', 'lan', null,
                array(
                        'lanid' => $ticket->getLanId()
                ));
    }

    /**
     * Description:   Shows the einzahlunsschein
     * Access:        Members
     */
    public function showpaymentAction ()
    {
        $event = $this->getRequest()->getParam('event', null);
        $ticketId = $this->getRequest()->getParam('id', null);
        $amount = $this->getRequest()->getParam('amount', null);

        if (is_null($event) || is_null($ticketId) || is_null($amount)) {
            return;
        } else {
            $qrBill = QrBill\QrBill::create();
            $qrBill->setCreditor(
                QrBill\DataGroup\Element\CombinedAddress::create(
                    'noprobLAN',
                    'Löwenstrasse 1',
                    '8585 Birwinken',
                    'CH'
                )
            );
            $qrBill->setCreditorInformation(
                QrBill\DataGroup\Element\CreditorInformation::create(
                    'CH0880808004923870407'
                )
            );
            $qrBill->setPaymentAmountInformation(
                QrBill\DataGroup\Element\PaymentAmountInformation::create(
                    'CHF',
                    $amount
                )
            );
            $qrBill->setPaymentReference(
                QrBill\DataGroup\Element\PaymentReference::create(
                    QrBill\DataGroup\Element\PaymentReference::TYPE_NON
                )
            );
            $qrBill->setAdditionalInformation(
                QrBill\DataGroup\Element\AdditionalInformation::create(
                    "$event - $ticketId"
                )
            );

            $img = $qrBill->getQrCode('png');
            header('Content-Type: image/png');
            imagepng($img);
            imagedestroy($img);
        }
    }

    private function sendHelpingMail(Application_Model_Ticket $ticket) {
        $isHelping = (bool) $ticket->getHelping();
        $isHelpingTemplatePart = $isHelping ? 'new' : 'removed';
        $helpingAdminMail = $this->_getMailOfChiefOfHelper();

        $mail = new Npl_Mail("utf-8");
        $mail->setRecipient($helpingAdminMail);
        $mail->setTemplate('helping-' . $isHelpingTemplatePart);
        $mail->setTemplatePath(APPLICATION_PATH . "/views/scripts/mails");
        $mail->username = $this->_currentUser->getUsername();
        $mail->email = $this->_currentUser->getMail();
        try {
            $mail->send();
            $this->_flashMessenger->setNamespace('success')->addMessage(
                'Wir haben unseren Ressortleiter für Helfer informiert'
            );
        } catch (Zend_Mail_Transport_Exception $e) {
            $this->_flashMessenger->setNamespace('error')->addMessage(
                'Unser Ressortleiter für Helfer konnte nicht informiert werden. Bitte melde dich direkt bei '
                . $helpingAdminMail
            );
        }
    }

    private function _getMailOfChiefOfHelper() {
        $fallbackMail = 'admin@noproblan.ch';
        $adminUserRolesMapper = new Application_Model_Mapper_UserRolesMapper();
        $adminRolesMapper = new Application_Model_Mapper_RolesMapper();

        $helferRole = $adminRolesMapper->findByRoleName('Helfer');

        if (count($helferRole) > 0) {
            $role = $helferRole[0];
            $roleId = $role->getId();

            if (isset($roleId)) {
                $helfers = $adminUserRolesMapper->findByRoleId($roleId);

                if (count($helfers) > 0) {
                    $helfer = $helfers[0];
                    $helferObject = new Application_Model_User();
                    $this->_mapperUsers->find($helfer->getUserId(), $helferObject);
                    $helferId = $helferObject->getId();

                    if (isset($helferId)) {
                        return $helferObject->getMail();
                    }
                }
            }
        }

        return $fallbackMail;
    }
}