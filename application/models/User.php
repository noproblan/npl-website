<?php

class Application_Model_User
{
	private static $_saltword = "@noproblan";

	protected $_id = null;
	protected $_username;
	protected $_password;
	protected $_salt;
	protected $_mail;
	protected $_active;
	protected $_mailVerified;
	protected $_registerDatetime;
	protected $_writtenDatetime;
	
	protected $_flashMessenger = null;
	
	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
		$this->_flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');
	}
	
	public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige User Eigenschaft');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Ungültige User Eigenschaft');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
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
	
	public function setId($id) {
		$this->_id = (int) $id;
		return $this;
	}
	
	public function getId() {
		return $this->_id;
	}
	
	public function setUsername($username) {
		$this->_username = (string) $username;
		return $this;
	}
	
	public function getUsername() {
		return $this->_username;
	}
	
	public function setPassword($password) {
		$this->_password = (string) $password;
		return $this;
	}
	
	public function getPassword() {
		return $this->_password;
	}
	
	public function setSalt($salt) {
		$this->_salt = (string) $salt;
		return $this;
	}
	
	public function getSalt() {
		return $this->_salt;
	}
	
	public function setMail($mail) {
		$this->_mail = (string) $mail;
		return $this;
	}
	
	public function getMail() {
		return $this->_mail;
	}
	
	public function setActive($active) {
		$this->_active = (bool) $active;
		return $this;
	}
	
	public function getActive() {
		return $this->_active;
	}
	
	public function setMailVerified($mailVerified) {
		$this->_mailVerified = (int) $mailVerified;
		return $this;
	}
	
	public function getMailVerified() {
		return $this->_mailVerified;
	}
	
	public function setWrittenDatetime($writtenDatetime) {
		$this->_writtenDatetime = date("d.m.Y H:i:s", strtotime($writtenDatetime));
		return $this;
	}
	
	public function getWrittenDatetime() {
		return $this->_writtenDatetime;
	}
	
	public function setRegisterDatetime($registerDatetime) {
		$this->_registerDatetime = $registerDatetime;
		return $this;
	}
	
	public function getRegisterDatetime() {
		return $this->_registerDatetime;
	}
	
	public function sendActivationMail() {
		$mail = new Npl_Mail("utf-8");
		$mail->setRecipient($this->getMail(), $this->getUsername());
		$mail->setTemplate("activation");
		$mail->setTemplatePath(APPLICATION_PATH . "/views/scripts/mails");
		$mail->username = $this->getUsername();
		$mail->id = $this->getId();
		$mail->token = $this->getSalt();
		
		try {
			$mail->send();
			$this->_flashMessenger->setNamespace('success')->addMessage('Eine E-Mail zur Aktivierung deines Accounts wurde an deine Mailadresse verschickt.');
		} catch (Zend_Mail_Transport_Exception $e) {
			$this->_flashMessenger->setNamespace('error')->addMessage('Die E-Mail zur Aktivierung deines Accounts konnte nicht versendet werden.');
		}
	}
	
	public function sendVerificationMail() 
	{
		$mail = new Npl_Mail("utf-8");
		$mail->setRecipient($this->getMail(), $this->getUsername());
		$mail->setTemplate("verification");
		$mail->setTemplatePath(APPLICATION_PATH . "/views/scripts/mails");
		$mail->username = $this->getUsername();
		$mail->id = $this->getId();
		$token = sha1($this->getMail());
		$mail->token = $token;
		
		try {
			$mail->send();
			$this->_flashMessenger->setNamespace('success')->addMessage('Eine E-Mail zur Überprüfung deiner Mailadresse wurde an deine Mailadresse verschickt.');
		} catch (Zend_Mail_Transport_Exception $e) {
			$this->_flashMessenger->setNamespace('error')->addMessage('Die E-Mail zur Überprüfung deiner Mailadresse konnte nicht versendet werden.');
		}
	}
	
	public function sendUsernameMail()
	{
		$mail = new Npl_Mail("utf-8");
		$mail->setRecipient($this->getMail(), $this->getUsername());
		$mail->setTemplate("forgot_username");
		$mail->setTemplatePath(APPLICATION_PATH . "/views/scripts/mails");
		$mail->username = $this->getUsername();
		
		try {
			$mail->send();
			$this->_flashMessenger->setNamespace('success')->addMessage('Eine E-Mail mit deinem Benutzernamen wurde an deine Mailadresse verschickt.');
		} catch (Zend_Mail_Transport_Exception $e) {
			$this->_flashMessenger->setNamespace('error')->addMessage('Die E-Mail mit deinem Benutzernamen konnte nicht versendet werden.');
		}
	}
	
	public function sendPasswordResetMail()
	{
		// Notice: Password only will be sent. A new one has to be generated with Mapper
		$mail = new Npl_Mail("utf-8");
		$mail->setRecipient($this->getMail(), $this->getUsername());
		$mail->setTemplate("forgot_password");
		$mail->setTemplatePath(APPLICATION_PATH . "/views/scripts/mails");
		$mail->username = $this->getUsername();
		$mail->id = $this->getId();
		$mail->token = time() . $this->getSalt();
		
		try {
			$mail->send();
			$this->_flashMessenger->setNamespace('success')->addMessage('Eine E-Mail zum Zurücksetzen deines Passworts wurde an deine Mailadresse verschickt.');
		} catch (Zend_Mail_Transport_Exception $e) {
			$this->_flashMessenger->setNamespace('error')->addMessage('Die E-Mail zum Zurücksetzen deines Passworts konnte nicht versendet werden.');
		}
	}
	
	public function sendNewsletterMail()
	{
		$mail = new Npl_Mail("utf-8");
		$mail->setRecipient($this->getMail(), $this->getUsername());
		$mail->setTemplate("newsletter");
		$mail->setTemplatePath(APPLICATION_PATH . "/views/scripts/mails");
		$mail->username = $this->getUsername();
		try {
			$mail->send();
			$this->_flashMessenger->setNamespace('success')->addMessage('Der Newsletter wurde erfolgreich an ' . $this->getUsername() . ' verschickt.');
		} catch (Zend_Mail_Transport_Exception $e) {
			$this->_flashMessenger->setNamespace('error')->addMessage('Der Newsletter konnte nicht an ' . $this->getUsername() . ' (' . $this->getMail() . ') versendet werden.');
		}
	}
	
	public function sendTeamMail()
	{
		$mail = new Npl_Mail("utf-8");
		$mail->setRecipient($this->getMail(), $this->getUsername());
		$mail->setTemplate("team");
		$mail->setTemplatePath(APPLICATION_PATH . "/views/scripts/mails");
		$mail->setFrom('noreply@noproblan.ch', 'noprobLAN Team Mailer');
		$mail->username = $this->getUsername();
		try {
			$mail->send();
			$this->_flashMessenger->setNamespace('success')->addMessage('Das Teammail wurde erfolgreich an ' . $this->getUsername() . ' verschickt.');
		} catch (Zend_Mail_Transport_Exception $e) {
			$this->_flashMessenger->setNamespace('error')->addMessage('Der Teammail konnte nicht an ' . $this->getUsername() . ' (' . $this->getMail() . ') versendet werden.');
		}
	}
	
	public function hasTicketOfLan($lanId)
	{
		$userId = $this->getId();
		if (!isset($userId)) return false;
		
		$tickets = new Application_Model_Mapper_TicketsMapper();
		$arrayOfTickets = $tickets->fetchAllByLanAndUserId($lanId, $userId);
		if (count($arrayOfTickets) >= 1) return true;
		
		return false;
	}
	
	/**
	 * Return if the user has role team
	 * @return bool
	 */
	public function isInTeam()
	{
		return $this->hasRole(Application_Model_Role::ID_TEAM);
	}
	
	/**
	 * Returns if the user has a given role or not.
	 * @param int $roleId
	 * @return bool
	 */
	public function hasRole($roleId)
	{
		$userrolesMapper = new Application_Model_Mapper_UserRolesMapper();
		$userroles = $userrolesMapper->findByUserId($this->getId());
		foreach ($userroles as $userrole) {
			/* @var $userrole Application_Model_UserRole */
			if ($userrole->getRoleId() == $roleId) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Generate salt from data combined with a fixed saltword to salt the salt
	 * @param $data Data to use as salt part
	 * @param $withSaltword 
	 * @return string
	 */
	public static function generateSaltFrom($data, $withSaltword = true)
	{
		if ($withSaltword) {
			return sha1($data . self::$_saltword);
		} else {
			return sha1($data);
		}
	}
	
	/**
	 * Encrypts password with sha1 and salt
	 * @param $password
	 * @param $salt
	 * @return string
	 */
	public static function encryptPassword($plaintextPassword, $salt)
	{
		return sha1($plaintextPassword . $salt);
	}
	
	/**
	 * Adds user to a given role if role exists
	 * @param int $roleId
	 */
	public function addToRole($roleId)
	{
		$mapperRoles = new Application_Model_Mapper_RolesMapper();
		$role = new Application_Model_Role();
		$mapperRoles->find($roleId, $role);
		if ($role->getId() != null) {
			$mapperUserroles = new Application_Model_Mapper_UserRolesMapper();
			if (!$this->hasRole($roleId)) {
				$userRole = new Application_Model_UserRole();
				$userRole->setRoleId($roleId);
				$userRole->setUserId($this->getId());
				$mapperUserroles->save($userRole);
			}
		}
	}
	
	/**
	 * Adds user to standard roles
	 */
	public function addToStandardRoles()
	{
		$this->addToRole(Application_Model_Role::ID_USER);
	}
}