<?php

class Application_Model_Lan
{

    protected $_id;

    protected $_name;

    protected $_startDateTime;

    protected $_endDateTime;

    protected $_registrationEndDateTime;

    protected $_plannedSeats;

    protected $_writtenDatetime;

    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Lan Eigenschaft');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Ungültige Lan Eigenschaft');
        }
        return $this->$method();
    }

    public function setOptions (array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setId ($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId ()
    {
        return $this->_id;
    }

    public function setName ($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getName ()
    {
        return $this->_name;
    }

    public function setStartDateTime ($startDateTime)
    {
        $this->_startDateTime = date("d.m.Y H:i", strtotime($startDateTime));
        
        return $this;
    }

    public function getStartDatetime ()
    {
        return $this->_startDateTime;
    }

    public function setRegistrationEndDateTime ($endDateTime)
    {
        if (! is_null($endDateTime)) {
            $this->_registrationEndDateTime = date("d.m.Y H:i", 
                    strtotime($endDateTime));
        } else {
            $this->_registrationEndDateTime = null;
        }
        return $this;
    }

    public function getRegistrationEndDateTime ()
    {
        return $this->_registrationEndDateTime;
    }

    public function setEndDateTime ($endDateTime)
    {
        $this->_endDateTime = date("d.m.Y H:i", strtotime($endDateTime));
        return $this;
    }

    public function getEndDatetime ()
    {
        return $this->_endDateTime;
    }

    public function setPlannedSeats ($plannedSeats)
    {
        $this->_plannedSeats = (int) $plannedSeats;
        return $this;
    }

    public function getPlannedSeats ()
    {
        return $this->_plannedSeats;
    }

    public function setWrittenDatetime ($writtenDatetime)
    {
        $this->_writtenDatetime = date("d.m.Y H:i:s", 
                strtotime($writtenDatetime));
        return $this;
    }

    public function getWrittenDatetime ()
    {
        return $this->_writtenDatetime;
    }

    /**
     * Iterates through all maps of a lan and returns number of seats
     *
     * @return int
     */
    public function getNumberOfSeats ()
    {
        $mapsMapper = new Application_Model_Mapper_MapsMapper();
        $counter = 0;
        $maps = $mapsMapper->fetchAllByLanId($this->getId());
        if (count($maps) >= 1) {
            $desksMapper = new Application_Model_Mapper_DesksMapper();
            foreach ($maps as $map) {
                $desks = $desksMapper->fetchAllByMapId($map->getId());
                if (count($desks) >= 1) {
                    $seatsMapper = new Application_Model_Mapper_SeatsMapper();
                    foreach ($desks as $desk) {
                        $seats = $seatsMapper->fetchAllByDeskId($desk->getId());
                        $counter = $counter + count($seats);
                    }
                }
            }
        }
        if ($counter == 0) {
            $counter = $this->getPlannedSeats();
        }
        return $counter;
    }

    /**
     * Counts all tickets with a seat
     *
     * @return int
     */
    public function getNumberOfReservedSeats ()
    {
        $ticketsMapper = new Application_Model_Mapper_TicketsMapper();
        $tickets = $ticketsMapper->fetchAllWithSeatByLanId($this->getId());
        return count($tickets);
    }

    /**
     * Gets number of seats
     * 
     * @return int
     */
    public function getNumberOfAvailableSeats ()
    {
        return $this->getNumberOfSeats();
    }

    /**
     * Gets number of participants without users in group 4 (team)
     * 
     * @return int
     */
    public function getNumberOfParticipantsWithoutTeam ()
    {
        $ticketsMapper = new Application_Model_Mapper_TicketsMapper();
        $usersMapper = new Application_Model_Mapper_UsersMapper();
        $userrolesMapper = new Application_Model_Mapper_UserRolesMapper();
        
        $counter = 0;
        $tickets = $ticketsMapper->fetchAllByLanId($this->getId());
        foreach ($tickets as $ticket) {
            /* @var $ticket Application_Model_Ticket */
            $user = new Application_Model_User();
            $usersMapper->find($ticket->getUserId(), $user);
            if (! $user->isInTeam()) {
                $counter = $counter + 1;
            }
        }
        return $counter;
    }

    /**
     * Gets number of participants which have prepaid
     * 
     * @return int
     */
    public function getNumberOfPrepaidParticipants ()
    {
        $ticketsMapper = new Application_Model_Mapper_TicketsMapper();
        $usersMapper = new Application_Model_Mapper_UsersMapper();
        $userrolesMapper = new Application_Model_Mapper_UserRolesMapper();
        
        $counter = 0;
        $tickets = $ticketsMapper->fetchAllByLanId($this->getId());
        foreach ($tickets as $ticket) {
            /* @var $ticket Application_Model_Ticket */
            if ($ticket->getStatus() == Application_Model_Ticket::STATUS_PREPAID) {
                $user = new Application_Model_User();
                $usersMapper->find($ticket->getUserId(), $user);
                if (! $user->isInTeam()) {
                    $counter = $counter + 1;
                }
            }
        }
        return $counter;
    }

    /**
     * Get number of participants which have paid
     * 
     * @return int
     */
    public function getNumberOfPaidParticipants ()
    {
        $ticketsMapper = new Application_Model_Mapper_TicketsMapper();
        $usersMapper = new Application_Model_Mapper_UsersMapper();
        $userrolesMapper = new Application_Model_Mapper_UserRolesMapper();
        
        $counter = 0;
        $tickets = $ticketsMapper->fetchAllByLanId($this->getId());
        foreach ($tickets as $ticket) {
            /* @var $ticket Application_Model_Ticket */
            if ($ticket->getStatus() == Application_Model_Ticket::STATUS_PAID) {
                $user = new Application_Model_User();
                $usersMapper->find($ticket->getUserId(), $user);
                if (! $user->isInTeam()) {
                    $counter = $counter + 1;
                }
            }
        }
        return $counter;
    }

    /**
     * Gets all tickets of lan.
     * 
     * @return Application_Model_User[]
     */
    public function getTickets ()
    {
        $ticketsMapper = new Application_Model_Mapper_TicketsMapper();
        $usersMapper = new Application_Model_Mapper_UsersMapper();
        
        $tickets = $ticketsMapper->fetchAllByLanId($this->getId());
        
        return $tickets;
    }

    /**
     * Gets all participants of a lan ordered by name.
     * 
     * @return $array
     */
    public function getParticipants ()
    {
        $tickets = $this->getTickets();
        $usersMapper = new Application_Model_Mapper_UsersMapper();
        $participants = array();
        foreach ($tickets as $ticket) {
            /* @var $ticket Application_Model_Ticket */
            $user = new Application_Model_User();
            $usersMapper->find($ticket->getUserId(), $user);
            if (! $user->hasRole(Application_Model_Role::ID_TEAM)) {
                $tmp['user'] = $user->getUsername();
                $tmp['id'] = $user->getId();
                $participants[] = $tmp;
            }
        }
        $this->natsort2d($participants);
        return $participants;
    }

    /**
     * Sorts 2-dimensional array
     *
     * @param array $aryInput            
     */
    // TODO: Extract
    private function natsort2d (&$aryInput)
    {
        $aryTemp = $aryOut = array();
        foreach ($aryInput as $key => $value) {
            reset($value);
            $aryTemp[$key] = current($value);
        }
        natcasesort($aryTemp);
        foreach ($aryTemp as $key => $value) {
            $aryOut[] = $aryInput[$key];
        }
        $aryInput = $aryOut;
    }
}