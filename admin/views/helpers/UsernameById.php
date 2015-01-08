<?php

class Zend_View_Helper_UsernameById extends Zend_View_Helper_Abstract
{

    public function usernameById ($id)
    {
        $usersMapper = new Application_Model_Mapper_UsersMapper();
        $user = new Application_Model_User();
        $usersMapper->find($id, $user);

        $userId = $user->getId();

        if (!isset($userId)) {
            return 'Unknown User';
        } else {
            return $user->getUsername();
        }
    }
}