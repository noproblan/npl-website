<?php

class Admin_Plugin_Auth_Acl extends Zend_Acl
{

    public function __construct ()
    {
        self::initResources();
        self::initRoles();
        self::initRights();
    }

    private function initResources ()
    {
        $mapper = new Admin_Model_Mapper_ResourcesMapper();
        $resources = $mapper->fetchAll();
        
        foreach ($resources as $resource) {
            $this->addResource($resource);
        }
    }

    private function initRoles ()
    {
        $mapper = new Admin_Model_Mapper_RolesMapper();
        $roles = $mapper->fetchAll();
        
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    private function initRights ()
    {
        $mapperResources = new Admin_Model_Mapper_ResourcesMapper();
        $mapperRights = new Admin_Model_Mapper_RightsMapper();
        $mapperRoles = new Admin_Model_Mapper_RolesMapper();
        $rights = $mapperRights->fetchAll();
        
        foreach ($rights as $right) {
            $resource = new Admin_Model_Resource();
            $role = new Admin_Model_Role();
            $mapperResources->find($right->getResourceId(), $resource);
            $mapperRoles->find($right->getRoleId(), $role);
            $this->allow($right->getRoleId(), $right->getResourceId());
        }

        $loginResource = new Admin_Model_Resource();
        $mapperResources->findByControllerAction('auth', 'login', $loginResource);

        $adminRole = new Admin_Model_Role();
        $mapperRoles->findByRoleName('Administrator', $adminRole);

        if ($adminRoleId = $adminRole->getRoleId()) {
            // Allow everything to administrator except login (Login not needed
            // 'cause of already logged in)
            $this->allow($adminRoleId);
            $this->deny($adminRoleId, $loginResource);
        }

        $errorResource = new Admin_Model_Resource();
        $mapperResources->findByControllerAction('error', '', $errorResource);

        // Allow Error-Controller (all Actions) for everyone
        $this->allow(null, $errorResource);
    }
}