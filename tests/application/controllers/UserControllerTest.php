<?php

class UserControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }
    
    public function tearDown()
    {
    	parent::tearDown();
    }

    // Index
    public function testUserShouldRedirectToRegistrationWhenNoActionIsGiven()
    {
    	$this->dispatch('/user');
    	$this->assertController('user');
    	$this->assertAction('index');
    	$this->assertRedirect();
    	$this->assertRedirectTo('/user/register');
    }
    
    // Index
    public function testUserIndexShouldRedirectToRegistration()
    {
    	$this->dispatch('/user/index');
    	$this->assertController('user');
    	$this->assertAction('index');
    	$this->assertRedirect();
    	$this->assertRedirectTo('/user/register');
    }
    
    // Index
    public function testUserIndexShouldRedirectToProfileWhenLoggedIn()
    {
    	$this->login();
    	 
    	$this->dispatch('/user');
    	$this->assertController('user');
    	$this->assertAction('index');
    	$this->assertRedirect();
    	$this->assertRedirectTo('/user/profile');
    	 
    	$this->logout();
    }
    
    // Verify
    public function testUserVerifyShouldBeInvalidWhenNoParameterIsGiven()
    {
    	$this->dispatch('/user/verify');
    	$this->assertQueryContentContains('div', 'Die Verifizierungsanfrage ist ungültig.');
    }
    
    // Verify
    public function testUserVerifyShouldBeInvalidWhenParameterIdIsNotValid()
    {
    	$this->dispatch('/user/verify/id/0/key/1234567890123456789012345678901234567890');
    	$this->assertQueryContentContains('div', 'Die Verifizierungsanfrage ist ungültig.');
    }
    
    // Verify
    public function testUserVerifyShouldBeInvalidWhenParameterKeyIsNotValid()
    {
    	$this->dispatch('/user/verify/id/3/key/1234');
    	$this->assertQueryContentContains('div', 'Die Verifizierungsanfrage ist ungültig.');
    }
    
    // Verify
    public function testUserVerifyShouldRedirectToIndexWhenUserIsAlreadyActivated()
    {
    	$mapper = new Application_Model_Mapper_UsersMapper();
    	$user = new Application_Model_User();
    	$mapper->find(3, $user);
    	$user->setMailVerified(true);
    	$mapper->save($user);
    	 
    	$this->dispatch('/user/verify/id/3/key/731464e0660dae127d2fff8146db8b9cf4099b41');
    	$this->assertRedirect();
    	$this->assertRedirectTo('/');
    }
    
    // Verify
    public function testUserVerifyShouldRedirectToIndexWhenEverythingIsOkay()
    {
    	$mapper = new Application_Model_Mapper_UsersMapper();
    	$user = new Application_Model_User();
    	$mapper->find(3, $user);
    	$user->setMailVerified(false);
    	$mapper->save($user);
    	 
    	$this->dispatch('/user/verify/id/3/key/731464e0660dae127d2fff8146db8b9cf4099b41');
    	$this->assertRedirect();
    	$this->assertRedirectTo('/');
    }
    
    // Register
    public function testUserRegister()
    {
    	// TODO Write test
    }
    
    // Activate
    public function testUserActivateShouldBeInvalidWhenNoParameterIsGiven()
    {
    	$this->dispatch('/user/activate');
    	$this->assertQueryContentContains('div', 'Die Aktivierungsanfrage ist ungültig.');
    }
    
    // Activate
    public function testUserActivateShouldBeInvalidWhenParameterIdIsNotValid()
    {
    	$this->dispatch('/user/activate/id/0/key/1234567890123456789012345678901234567890');
    	$this->assertQueryContentContains('div', 'Die Aktivierungsanfrage ist ungültig.');
    }
    
    // Activate
    public function testUserActivateShouldBeInvalidWhenParameterKeyIsNotValid()
    {
    	$this->dispatch('/user/activate/id/3/key/1234');
    	$this->assertQueryContentContains('div', 'Die Aktivierungsanfrage ist ungültig.');
    }
    
    // Activate
    public function testUserActivateShouldRedirectToIndexWhenUserIsAlreadyActivated()
    {
    	$mapper = new Application_Model_Mapper_UsersMapper();
    	$user = new Application_Model_User();
    	$mapper->find(3, $user);
    	$user->setActive(true);
    	$mapper->save($user);
    	
    	$this->dispatch('/user/activate/id/3/key/5c403b904568d9c068e78b97880cf995b67eaf44');
    	$this->assertRedirect();
    	$this->assertRedirectTo('/');
    }
    
    // Activate
    public function testUserActivateShouldRedirectToIndexWhenEverythingIsOkay()
    {
    	$mapper = new Application_Model_Mapper_UsersMapper();
    	$user = new Application_Model_User();
    	$mapper->find(3, $user);
    	$user->setActive(false);
    	$mapper->save($user);
    	
    	$this->dispatch('/user/activate/id/3/key/5c403b904568d9c068e78b97880cf995b67eaf44');
    	$this->assertRedirect();
    	$this->assertRedirectTo('/');
    }
    
    // Resend Activation
    public function testUserResendActivation()
    {
    	// TODO Write test
    }
    
    // Reset Password
    public function testUserResetPassword()
    {
    	// TODO Write test
    }
    
    // Profile
    public function testUserProfile()
    {
    	// TODO Write test
    }
    
    // Change Password
    public function testChangePassword()
    {
    	// TODO Write test
    }
    
    // Change Mail
    public function testChangeMail()
    {
    	// TODO Write test
    }
    
    // Resend Verification
    public function testResendVerification()
    {
    	// TODO Write test
    }
    
    // Delete
    public function testDelete()
    {
    	// TODO Write test
    }
    
    // Private functions
    private function login()
    {
    	$this->request->setMethod('POST');
    	$this->request->setPost(
    		array(
    			'username' => 'Testaccount',
    			'password' => 'Testaccount' 	
    		)
    	);
    	$this->dispatch('/auth/login');
    	$this->resetRequest();
    	$this->resetResponse();
    }
    
    private function logout()
    {
    	$this->dispatch('/auth/logout');
    	$this->resetRequest();
    	$this->resetResponse();
    }
}



