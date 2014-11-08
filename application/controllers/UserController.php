<?php

class UserController extends Zend_Controller_Action
{
	/**
	 * @var Application_Model_Mapper_UsersMapper
	 */
	protected $_users = null;
	/** 
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
	 * 
	 * @var Npl_Helper_InstantMessenger
	 */
	protected $_instantMessenger = null;
	/**
	 * 
	 * @var Zend_Filter_StripTags
	 */
	protected $_stripFilter = null;
	/**
	 * 
	 * @var Zend_Validate_Digits
	 */
	protected $_digitValidator = null;
	/**
	 * 
	 * @var Zend_Validate_StringLength
	 */
	protected $_shaLengthValidator = null;
	/**
	 * 
	 * @var Zend_Validate_Db_RecordExists
	 */
	protected $_userIDValidator = null;
	/**
	 * 
	 * @var Zend_Validate_Db_RecordExists
	 */
	protected $_userSaltValidator = null;
	/**
	 * 
	 * @var Zend_Validate_Db_RecordExists
	 */
	private $_oldUserSaltValidator = null;
	
	const MSG_PARAMETER_INVALID 				= "Die angegebenen Parameter sind nicht gültig.";
	const MSG_USER_DOESNT_EXISTS				= "Der Benutzer existiert nicht.";
	const MSG_ACCOUNT_CREATED_SUCCESSFUL 		= "Dein Account wurde erfolgreich erstellt.";
	const MSG_ACCOUNT_DELETED_SUCCESSFUL 		= "Dein Account wurde erfolgreich gelöscht.";
	const MSG_ACCOUNT_MIGRATED_SUCCESSFUL 		= "Dein Account wurde erfolgreich übernommen.";
	const MSG_ACTIVATION_INVALID 				= "Die Aktivierungsanfrage ist ungültig.";
	const MSG_ACTIVATION_SUCCESSFUL 			= "Der Account wurde erfolgreich aktiviert. Du kannst dich nun einloggen.";
	const MSG_ALREADY_ACTIVATED 				= "Der Account wurde bereits aktiviert. Du kannst dich einloggen.";
	const MSG_ALREADY_VERIFICATED 				= "Die Mailadresse wurde bereits verifiziert.";
	const MSG_MAIL_CHANGE_SUCCESSFUL 			= "Deine Mailadresse wurde erfolgreich geändert.";
	const MSG_MAIL_IS_IDENTICAL 				= "Die alte Mailadresse und die neue Mailadresse sind identisch.";
	const MSG_MAIL_NOT_VERIFIED					= "Deine Mailadresse ist noch nicht verifiziert.";
	const MSG_PASSWORD_CHANGE_REQUEST_INVALID 	= "Die Anfrage zur Änderung des Passworts ist ungültig.";
	const MSG_PASSWORD_CHANGE_SUCCESSFUL 		= "Dein Password wurde erfolgreich geändert. Du kannst dich jetzt mit dem neuen Passwort einloggen.";
	const MSG_PASSWORD_IS_IDENTICAL 			= "Das alte Passwort und das neue Passwort sind gleich.";
	const MSG_PASSWORD_IS_INVALID 				= "Das angegebene Passwort ist falsch.";
	const MSG_RESEND_ACTIVATION_INVALID 		= "Die Anfrage zum erneuten Senden der Aktivierung ist ungültig.";
	const MSG_RESEND_PASSWORD_REQUEST 			= "Neue Anfrage zum Zurücksetzen des Passworts versenden?";
	const MSG_RESEND_VERIFICATION 				= "Verifizierungsmail erneut senden?";
	const MSG_VERIFICATION_INVALID 				= "Die Verifizierungsanfrage ist ungültig.";
	const MSG_VERIFICATION_SUCCESSFUL 			= "Die Mailadresse wurde erfolgreich verifiziert.";
	const URL_FORGOT_PASSWORD 					= "/user/forgotpassword";
	const URL_RESEND_VERIFICATION 				= "/user/resendverification";
	
	public function init()
	{
		// Models
		$this->_users = new Application_Model_Mapper_UsersMapper();
		$this->_currentUser = new Application_Model_User();
		// User loading
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$this->_users->find(Zend_Auth::getInstance()->getIdentity()->id, $this->_currentUser);
		}
		// Messengers
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->_instantMessenger = new Npl_Helper_InstantMessenger();
		// Filters
		$this->_stripFilter = new Zend_Filter_StripTags();
		// Validators
		$this->_digitValidator = new Zend_Validate_Digits();
		$this->_shaLengthValidator = new Zend_Validate_StringLength(
				array (
						'max' => 40,
						'min' => 40
				)
		);
		$this->_userIDValidator = new Zend_Validate_Db_RecordExists(
			array (
				'table' => 'npl_users',
				'field' => 'id'
			)
		);
		$this->_userSaltValidator = new Zend_Validate_Db_RecordExists(
			array (
				'table' => 'npl_users',
				'field' => 'salt'
			)
		);
		$this->_oldUserSaltValidator = new Zend_Validate_Db_RecordExists(
			array (
				'table' => 'npl_oldusers',
				'field' => 'salt'
			)
		);
	}
	
	/**
	 * Name:		Index
	 * Description:	Redirects to the profile of the account
	 * Access:		Guests, Members
	 */
	public function indexAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			return $this->_helper->redirector('profile');
		} else {
			return $this->_helper->redirector('register');
		}
	}
	
	/**
	 * Name: 		Verify
	 * Description:	Search for unactivated user with id and key and activate the user
	 * Access:		Guests, Members
	 */
	public function verifyAction()
	{
		$id = $this->getRequest()->getParam('id', null);
		$key = $this->getRequest()->getParam('key', null);
		if (!is_Null($id) && !is_Null($key)) {
			$id = $this->_stripFilter->filter($id);
			$key = $this->_stripFilter->filter($key);	
			if ($this->_digitValidator->isValid($id) && $this->_userIDValidator->isValid($id)) {
				if ($this->_shaLengthValidator->isValid($key)) {
					$user = new Application_Model_User();
					$this->_users->find($id, $user);
					if ($key === Application_Model_User::generateSaltFrom($user->getMail(), false)) {
						if (!$user->getMailVerified()) {
							$user->setMailVerified(true);
							$this->_users->save($user);
							$this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_VERIFICATION_SUCCESSFUL);
							return $this->_helper->redirector('index', 'index');
						} else {
							$this->_flashMessenger->setNamespace('notice')->addMessage(self::MSG_ALREADY_VERIFICATED);
							return $this->_helper->redirector('index', 'index');
						}
					}
				}
			}
		}
		return $this->_instantMessenger->addError(self::MSG_VERIFICATION_INVALID);
	}
	
	/**
	 * Name: 		Register
	 * Description:	Allows guests to register an account
	 * Access:		Guests
	 */
	public function registerAction()
	{
		$form = new Application_Form_Register();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$data = $form->getValues();
				$this->_registerUser($data);
			} else {
				foreach ($form->getMessages() as $field => $message) {
					$label = $form->getElement($field)->getLabel();
					foreach ($message as $key => $value) {
						$this->_instantMessenger->addError("<b>" . $label . "</b> " . $value);
					}
				}
			}
		}
		return $this->view->form = $form;
	}
	
	/**
	 * Name: 		Activate
	 * Description:	Search for unactivated user with id and key and activate the user
	 * Access:		Guests
	 */
	public function activateAction()
	{
		$id = $this->getRequest()->getParam('id', null);
		$key = $this->getRequest()->getParam('key', null);
		if (!is_Null($id) && !is_Null($key)) {
			$id = $this->_stripFilter->filter($id);
			$key = $this->_stripFilter->filter($key);
			if ($this->_digitValidator->isValid($id) && $this->_userIDValidator->isValid($id)) {
				if ($this->_shaLengthValidator->isValid($key) && $this->_userSaltValidator->isValid($key)) {
					$user = new Application_Model_User();
					$this->_users->find($id, $user);
					if (!$user->getActive()) {
						$user->setActive(true);
						if (!$user->getMailVerified()) $user->setMailVerified(true);
						$this->_users->save($user);
						$this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_ACTIVATION_SUCCESSFUL);
						return $this->_helper->redirector('index', 'index');
					} else {
						$this->_flashMessenger->setNamespace('notice')->addMessage(self::MSG_ALREADY_ACTIVATED);
						return $this->_helper->redirector('index', 'index');
					}
				}
			}
		}
		return $this->_instantMessenger->addError(self::MSG_ACTIVATION_INVALID);
	}
	
	/**
	 * Name: 		ForgotPassword
	 * Description:	Shows a form to enter mail address of a user to send password reset instructions
	 * Access:		Guests
	 */
	public function forgotpasswordAction()
	{
		$this->view->form = $this->_forgotCredential("password");
	}
	
	/**
	 * Name: 		ForgotUsername
	 * Description:	Shows a form to enter mail address of a user to send username
	 * Access:		Guests
	 */
	public function forgotusernameAction()
	{
		$this->view->form = $this->_forgotCredential("username");
	}
	
	/**
	 * Name: 		ResendActivation
	 * Description:	Sends the activation mail again
	 * Access:		Guests
	 */
	public function resendactivationAction()
	{
		$id = $this->getRequest()->getParam('id', null);
		$key = $this->getRequest()->getParam('key', null);
		if (!is_Null($key) && !is_Null($id)) {
			$key = $this->_stripFilter->filter($key);
			$id = $this->_stripFilter->filter($id);
			if ($this->_digitValidator->isValid($id) && $this->_userIDValidator->isValid($id)) {
				if ($this->_shaLengthValidator->isValid($key) && $this->_userSaltValidator->isValid($key)) {
					$user = new Application_Model_User();
					$this->_users->findBySalt($key, $user);
					if (!$user->getActive()) {
						$user->sendActivationMail();
						return $this->_helper->redirector('index', 'index');
					} else {
						$this->_flashMessenger->setNamespace('notice')->addMessage(self::MSG_ALREADY_ACTIVATED);
						return $this->_helper->redirector('index', 'index');
					}
			 	}
			}
		}
		return $this->_instantMessenger->addError(self::MSG_RESEND_ACTIVATION_INVALID);
	}
	
	// Notice: User receives link, opens link and set new password with form
	// TODO: Refactor!!
	/**
	 * Name: 		ResetPassword
	 * Description:	Resets the password of a user with a new one if parameters are correct.
	 * Access:		Guests
	 */
	public function resetpasswordAction()
	{
		$form = new Application_Form_ResetPassword();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$data = $form->getValues();
				$lenghtValidator = new Zend_Validate_StringLength(array(
					'min' => 41
				));
				$id = $this->_stripFilter->filter($data['userid']);
				$key = $this->_stripFilter->filter($data['userhash']);
				$password = $this->_stripFilter->filter($data['password']);
				if ($this->_digitValidator->isValid($id) && $this->_userIDValidator->isValid($id)) {
					if ($lenghtValidator->isValid($key)) {
						$subkey = substr($key, strlen($key) - 40, 40);
						$timestamp = substr($key, 0, strlen($key) - 40);
						if ($this->_digitValidator->isValid($timestamp) && $this->_userSaltValidator->isValid($subkey)) {
							if (($timestamp + 604800) >= time()) {
								$user = new Application_Model_User();
								$this->_users->find($id, $user);
								$user->setPassword(Application_Model_User::encryptPassword($password, $user->getSalt()));
								$this->_users->save($user);
								$this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_PASSWORD_CHANGE_SUCCESSFUL);
								return $this->_helper->redirector('index', 'index');
							}
							$this->_instantMessenger->addError('Die Anfrage ist älter als 7 Tage.');
							$this->_instantMessenger->addNotice('<a href="' . self::URL_FORGOT_PASSWORD . '">' . self::MSG_RESEND_PASSWORD_REQUEST . '</a>');
							return $this->view->form = "";
						}
					}
				}
				$this->_instantMessenger->addError(self::MSG_PASSWORD_CHANGE_REQUEST_INVALID);
			} else {
				foreach ($form->getMessages() as $field => $message) {
					$label = $form->getElement($field)->getLabel();
					foreach ($message as $key => $value) {
						$this->_instantMessenger->addError("<b>" . $label . "</b> " . $value);
					}
				}
			}
		} elseif ($this->getRequest()->isGet()) {
			$id = $this->getRequest()->getParam('id', null);
			$key = $this->getRequest()->getParam('key', null);
			if (!is_Null($id) && !is_Null($key)) {
				$lenghtValidator = new Zend_Validate_StringLength(array(
						'min' => 41
				));
				$id = $this->_stripFilter->filter($id);
				$key = $this->_stripFilter->filter($key);
				if ($this->_digitValidator->isValid($id) && $this->_userIDValidator->isValid($id)) {
					if ($lenghtValidator->isValid($key)) {
						$subkey = substr($key, strlen($key) - 40, 40);
						$timestamp = substr($key, 0, strlen($key) - 40);
						if ($this->_digitValidator->isValid($timestamp) && $this->_userSaltValidator->isValid($subkey)) {
							if (($timestamp + 604800) >= time()) {
								$data = array(
									'userid' => $id,
									'userhash' => $key
								);
								$form->populate($data);
								return $this->view->form = $form;
							}
							$this->_instantMessenger->addError('Die Anfrage ist älter als 7 Tage.');
							$this->_instantMessenger->addNotice('<a href="' . self::URL_FORGOT_PASSWORD . '">' . self::MSG_RESEND_PASSWORD_REQUEST . '</a>');
							return $this->view->form = "";
						}
					}
				}
			}
			$this->_instantMessenger->addError(self::MSG_PASSWORD_CHANGE_REQUEST_INVALID);
			return $this->view->form = "";
		}
		return $this->view->form = $form;
	}
	
	/**
	 * Description:	Shows own profile and account options.
	 * Access:		Members
	 */
	public function accountAction()
	{
		$buttons = array();
		if (!$this->_currentUser->getMailVerified()) {
			$this->_instantMessenger->addNotice(
					self::MSG_MAIL_NOT_VERIFIED . "<br />" . 
					'<a href="' . self::URL_RESEND_VERIFICATION . '">' . 
						self::MSG_RESEND_VERIFICATION . 
					'</a>'
			);
		}
		
		$this->view->username = $this->_currentUser->getUsername();
		$this->view->mail = $this->_currentUser->getMail();
		$this->view->gravatar = $this->view->gravatar()
			->setEmail($this->_currentUser->getMail())
			->setDefaultImg(Zend_View_Helper_Gravatar::DEFAULT_MM);
		
		$lans = new Application_Model_Mapper_LansMapper();
		$mapperTickets = new Application_Model_Mapper_TicketsMapper();
		$comingLans = $lans->fetchComing();
		$attendingLans = array();		
		foreach ($comingLans as $key => $lanModel) {
			if ($this->_currentUser->hasTicketOfLan($lanModel->getId())) {
				$tickets = $mapperTickets->fetchAllByLanAndUserId($lanModel->getId(), $this->_currentUser->getId());
				$ticket = $tickets[0];
				$paymentstatus = $ticket->getStatus();
			} else {
				$paymentstatus = 'notpaid';
			}
			/* @var $lanModel Application_Model_Lan */
			if (is_null($lanModel->getRegistrationEndDateTime())) {
				$registrationPossible = true;
			} else {
				$regEndDateTime = new DateTime($lanModel->getRegistrationEndDateTime());
				if ($regEndDateTime > new DateTime()) {
					$registrationPossible = true;
				} else {
					$registrationPossible = false;
				}
			}
			$attendingLans[] = array(
					"id"		=> $lanModel->getId(),
					"name"      => $lanModel->getName(),
					"startdate" => $lanModel->getStartDatetime(),
					"attending" => $this->_currentUser->hasTicketOfLan($lanModel->getId()),
					"paid"		=> $paymentstatus,
					"registration_possible" => $registrationPossible
			);
		}
		$this->view->attendingLans = $attendingLans;
		
		$mapperTickets = new Application_Model_Mapper_TicketsMapper();
		$tickets = $mapperTickets->fetchAllByUserId($this->_currentUser->getId());
		$this->view->userTickets = $tickets;
		return;
	}
	
	/**
	 * Description:	Profile of other users by id or redirect to own profile.
	 * Access:		Guest, Members
	 */
	public function profileAction()
	{
		$id = $this->getRequest()->getParam('id', null);
		
		if (is_null($id) && 
				$this->_currentUser->getId() == Zend_Auth::getInstance()->getIdentity()->id) {
			return $this->_helper->redirector('account');
		}
		
		$id = $this->_stripFilter->filter($id);
		if (!$this->_digitValidator->isValid($id)) {
			$this->view->username = null;
			$this->view->attendingLans = null;
			return $this->_instantMessenger->addError(self::MSG_PARAMETER_INVALID);
		}
		
		if (!$this->_userIDValidator->isValid($id) || $id < 3) {
			$this->view->username = null;
			$this->view->attendingLans = null;
			return $this->_instantMessenger->addError(self::MSG_USER_DOESNT_EXISTS);
		}
		
		if ($this->_currentUser->getId() == $id) {
			return $this->_helper->redirector('account');
		}
				
		$user = new Application_Model_User();
		$this->_users->find($id, $user);
		$this->view->username = $user->getUsername();
		
		$this->view->gravatar = $this->view->gravatar()
			->setEmail($user->getMail())
			->setDefaultImg(Zend_View_Helper_Gravatar::DEFAULT_MM);
		
		$lans = new Application_Model_Mapper_LansMapper();
		$comingLans = $lans->fetchComing();
		$attendingLans = array();
		foreach($comingLans as $key => $lanModel) {
			/* @var $lanModel Application_Model_Lan */
			$attendingLans[] = array(
					"id"		=> $lanModel->getId(),
					"name"      => $lanModel->getName(),
					"startdate" => $lanModel->getStartDatetime(),
					"attending" => $user->hasTicketOfLan($lanModel->getId())
			);
		}
		$this->view->attendingLans = $attendingLans;
		return;
	}
	
	/**
	 * Name: 		ChangePassword
	 * Description:	Changes the current password
	 * Access:		Members
	 */
	public function changepasswordAction()
	{
		$form = new Application_Form_ChangePassword();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$data = $form->getValues();
				$oldPassword = $this->_stripFilter->filter($data['oldPassword']);
				$newPassword = $this->_stripFilter->filter($data['password']);
				$oldPasswordHashed = Application_Model_User::encryptPassword($oldPassword, $this->_currentUser->getSalt());
				$newPasswordHashed = Application_Model_User::encryptPassword($newPassword, $this->_currentUser->getSalt());
				if ($this->_currentUser->getPassword() === $oldPasswordHashed) {
					if ($oldPasswordHashed !== $newPasswordHashed) {
						$this->_currentUser->setPassword($newPasswordHashed);
						$this->_users->save($this->_currentUser);
						$this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_PASSWORD_CHANGE_SUCCESSFUL);
						return $this->_helper->redirector('profile', 'user');
					} else {
						$this->_instantMessenger->addError(self::MSG_PASSWORD_IS_IDENTICAL);
					}
				} else {
					$this->_instantMessenger->addError(self::MSG_PASSWORD_IS_INVALID);
				}
			} else {
				foreach ($form->getMessages() as $field => $message) {
					$label = $form->getElement($field)->getLabel();
					foreach ($message as $key => $value) {
						$this->_instantMessenger->addError("<b>" . $label . "</b> " . $value);
					}
				}
			}
		}
		return $this->view->form = $form;
	}
	
	/**
	 * Name: 		ChangeMail
	 * Description:	Changes the current e-mail
	 * Access:		Members
	 */
	public function changemailAction()
	{
		$form = new Application_Form_ChangeMail();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$data = $form->getValues();
				$mail = $this->_stripFilter->filter($data['mail']);
				if ($this->_currentUser->getMail() !== $mail) {
					$this->_currentUser->setMail($mail);
					$this->_currentUser->setMailVerified(false);
					$this->_users->save($this->_currentUser);
					$this->_currentUser->sendVerificationMail();
					$this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_MAIL_CHANGE_SUCCESSFUL);
					return $this->_helper->redirector('profile', 'user');
				} else {
					$this->_instantMessenger->addError(self::MSG_MAIL_IS_IDENTICAL);
				}
			} else {
				foreach ($form->getMessages() as $field => $message) {
					$label = $form->getElement($field)->getLabel();
					foreach ($message as $key => $value) {
						$this->_instantMessenger->addError("<b>" . $label . "</b> " . $value);
					}
				}
			}
		}
		return $this->view->form = $form;
	}
	
	/**
	 * Name: 		ResendVerification
	 * Description:	Sends the verification mail again
	 * Access:		Members
	 */
	public function resendverificationAction()
	{
		if (!$this->_currentUser->getMailVerified()) {
			$this->_currentUser->sendVerificationMail();
			return $this->_helper->redirector('profile', 'user');
		}
		return $this->_instantMessenger->addNotice(self::MSG_ALREADY_VERIFICATED);
	}
	
	/**
	 * Name: 		Delete
	 * Description:	Delete the user by his id
	 * Access:		Members
	 */
	public function deleteAction()
	{
		$form = new Application_Form_DeleteAccount();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$data = $form->getValues();
				if ($this->_currentUser->getPassword() === Application_Model_User::encryptPassword($data['password'], $this->_currentUser->getSalt())) {
					$this->_users->delete($this->_currentUser);
					Zend_Auth::getInstance()->clearIdentity();
					$this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_ACCOUNT_DELETED_SUCCESSFUL);
					return $this->_helper->redirector('index', 'index');
				} else {
					$this->_instantMessenger->addError('Das Password ist nicht korrekt!');
				}
			} else {
				foreach ($form->getMessages() as $field => $message) {
					$label = $form->getElement($field)->getLabel();
					foreach ($message as $key => $value) {
						$this->_instantMessenger->addError("<b>" . $label . "</b> " . $value);
					}
				}
			}
		}
		return $this->view->form = $form;
	}
	
	/**
	 * Name: 		Migrate
	 * Description:	Allows guests to register an account
	 * Access:		Guests
	 */
	public function migrateAction()
	{
		$form = new Application_Form_Register();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$data = $form->getValues();
				$this->_migrateUser($data);
			} else {
				foreach ($form->getMessages() as $field => $message) {
					$label = $form->getElement($field)->getLabel();
					foreach ($message as $key => $value) {
						$this->_instantMessenger->addError("<b>" . $label . "</b> " . $value);
					}
				}
			}
		} else {
			$key = $this->getRequest()->getParam('key', null);
			if (!is_Null($key)) {
				$key = $this->_stripFilter->filter($key);
				if ($this->_shaLengthValidator->isValid($key) && $this->_oldUserSaltValidator->isValid($key)) {
					$oldUser = new Application_Model_OldUser();
					$oldUserMapper = new Application_Model_Mapper_OldUsersMapper();
					$oldUserMapper->findBySalt($key, $oldUser);
					$sessionNamespace = new Zend_Session_Namespace('Migration');
					$sessionNamespace->oldUserId = $oldUser->getId();
					$form->getElement('username')->setValue($oldUser->getUsername());
					$form->getElement('password')->setLabel('Neues Passwort:');
					$form->getElement('mail')->setValue($oldUser->getMail());
					$form->getElement('submit')->setLabel('Übernehmen');
				} else {
					return $this->_helper->redirector('register', 'user');
				}
			} else {
				return $this->_helper->redirector('register', 'user');
			}
		}
		return $this->view->form = $form;
	}
	
	/**
	 * Name: 		Migrationmailer
	 * Description:	Sends a migration mail to all old users
	 * Access:		Admin
	 */
	public function migrationmailerAction()
	{
		$oldUserMapper = new Application_Model_Mapper_OldUsersMapper();
		$oldUsers = $oldUserMapper->fetchAll();
		foreach ($oldUsers as $oldUser) {
			/* @var $oldUser Application_Model_OldUser */
			$oldUser->sendMigrationMail();
		}
		$this->_helper->redirector('index', 'index');
	}
	
	public function newslettermailerAction()
	{
		$users = $this->_users->fetchAll();
		set_time_limit(0);
		foreach ($users as $user) { /* @var $user Application_Model_User */
			if ($user->getId() > 2) {
				$user->sendNewsletterMail();
			}
		}
		set_time_limit(30);
		$this->_helper->redirector('index', 'index');
	}
	
	public function teammailerAction()
	{
		$mapperUserroles = new Application_Model_Mapper_UserRolesMapper();
		$userroles = $mapperUserroles->findByRoleId(Application_Model_Role::ID_TEAM);
		set_time_limit(0);
		foreach ($userroles as $userrole) { /* @var $userrole Application_Model_UserRole */
			$user = new Application_Model_User();
			$this->_users->find($userrole->getUserId(), $user);
			$user->sendTeamMail();
		}
		set_time_limit(30);
		$this->_helper->redirector('index', 'index');
	}
	
	/**
	 * Name: 		registerUser
	 * Description:	Sets the local user object and saves it
	 * Access:		Private
	 */
	protected function _registerUser($data)
	{
		$user = new Application_Model_User();
		$user->setUsername($data['username']);
		$user->setMail($data['mail']);
		$user->setSalt(Application_Model_User::generateSaltFrom($data['username']));
		$user->setPassword(Application_Model_User::encryptPassword($data['password'], Application_Model_User::generateSaltFrom($data['username'])));
		$user->setActive(false);
		$user->setMailVerified(false);
		$user->setRegisterDateTime(date('Y-m-d h:i:s'));
		$this->_users->save($user);
		$user->addToStandardRoles();
		$user->sendActivationMail();
		$this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_ACCOUNT_CREATED_SUCCESSFUL);
		return $this->_helper->redirector('index', 'index');
	}
	
	/**
	 * Name: 		migrateUser
	 * Description:	Sets the local user object and saves it
	 * Access:		Private
	 */
	protected function _migrateUser($data)
	{
		$user = new Application_Model_User();
		$user->setUsername($data['username']);
		$user->setMail($data['mail']);
		$user->setSalt(Application_Model_User::generateSaltFrom($data['username']));
		$user->setPassword(Application_Model_User::encryptPassword($data['password'], Application_Model_User::generateSaltFrom($data['username'])));
		$user->setActive(true);
		$user->setMailVerified(false);
		$user->setRegisterDateTime(date('Y-m-d h:i:s'));
		$this->_users->save($user);
		$user->addToStandardRoles();
		$sessionNamespace = new Zend_Session_Namespace('Migration');
		if (isset($sessionNamespace->oldUserId)) {
			$id = $sessionNamespace->oldUserId;
			$oldUserMapper = new Application_Model_Mapper_OldUsersMapper();
			$oldUser = new Application_Model_OldUser();
			$oldUserMapper->find($id, $oldUser);
			$oldUserMapper->delete($oldUser);
		}
		$user->sendVerificationMail();
		$this->_flashMessenger->setNamespace('success')->addMessage(self::MSG_ACCOUNT_MIGRATED_SUCCESSFUL);
		return $this->_helper->redirector('index', 'index');
	}
	
	/**
	 * Name: 		forgotCredential
	 * Description:	Generates form and handles requests
	 * Access:		Private
	 */
	protected function _forgotCredential($credential = null)
	{
		if ($credential != "password" && $credential != "username") {
			return;
		}
		$form = new Application_Form_RequestMail();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$data = $form->getValues();
				$user = new Application_Model_User();
				$this->_users->findByMail($data['mail'], $user);
				switch ($credential) {
					case "password":
						$user->sendPasswordResetMail();
						break;
					case "username":
						$user->sendUsernameMail();
						break;
				}
				return $this->_helper->redirector('index', 'index');
			} else {
				foreach ($form->getMessages() as $field => $message) {
					$label = $form->getElement($field)->getLabel();
					foreach ($message as $key => $value) {
						$this->_instantMessenger->addError("<b>" . $label . "</b> " . $value);
					}
				}
			}
		}
		return $this->view->form = $form;
	}
}