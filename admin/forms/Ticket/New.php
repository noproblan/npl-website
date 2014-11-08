<?php

class Admin_Form_Ticket_New extends Zend_Form
{
	public function init()
	{
		$this->setAttrib('id', 'participate');
		$this->setAction('');
		$this->setMethod('post');
		
		$lanMapper = new Application_Model_Mapper_LansMapper();
		$currentLans = $lanMapper->fetchCurrent();
		$comingLans = $lanMapper->fetchComing();
		$lanObjects = array_merge($currentLans, $comingLans);
		$possibleLans = array();
		foreach ($lanObjects as $lan) {
			/* @var $lan Application_Model_Lan */
			$possibleLans[$lan->getId()] = $lan->getName();
		}
		
		$userMapper = new Application_Model_Mapper_UsersMapper();
		$userObjects = $userMapper->fetchAll('active = 1', 'username');
		$possibleUsers = array();
		foreach ($userObjects as $user) {
			/* @var $user Application_Model_User */
			$possibleUsers[$user->getId()] = $user->getUsername();
		}

        $possibleExtras = array(
            'none' => 'Ohne Extras',
            'breakfast' => 'Frühstück',
            'dinner' => 'Abendessen',
            'both' => 'Frühstück & Abendessen',
        );

        $possibleStatus = array(
            'notpaid' => 'Nicht bezahlt',
            'prepaid' => 'Vorausbezahlt',
            'paid' => 'Abendkasse',
        );
		
		$lans = new Npl_Form_Element_Select('lans');
		$lans->setLabel('Lan:');
		$lans->setMultiOptions($possibleLans);
		$users = new Npl_Form_Element_Select('users');
		$users->setLabel('User:');
		$users->setMultiOptions($possibleUsers);
        $extras = new Npl_Form_Element_Select('extras');
        $extras->setLabel('Extras:');
        $extras->setMultiOptions($possibleExtras);
        $status = new Npl_Form_Element_Select('status');
        $status->setLabel('Status:');
        $status->setMultiOptions($possibleStatus);
		$participate = new Zend_Form_Element_Submit(
			'submit', 
			array(
				'required' => false,
				'ignore' => true,
				'label' => 'Anmelden',
			)
		);
		
		$this->addElement($lans);
		$this->addElement($users);
        $this->addElement($extras);
        $this->addElement($status);
        $this->addElement($participate);
	}
}