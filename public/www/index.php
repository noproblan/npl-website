<?php

// Define path to application directory
defined('APPLICATION_PATH') ||
         define('APPLICATION_PATH', 
                realpath(dirname(__FILE__) . '/../../application'));

// Define application environment
defined('APPLICATION_ENV') ||
         define('APPLICATION_ENV', 
                (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(
        implode(PATH_SEPARATOR, 
                array(
                        realpath(APPLICATION_PATH . '/../library'),
                        get_include_path()
                )));

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Npl_');

// Erlaube das Laden von Models und Plugins aus der Adminapplikation
$externResLoader = new Zend_Loader_Autoloader_Resource(
    array(
        'basePath' => APPLICATION_PATH . '/../admin',
        'namespace' => 'Admin_'
    ));
$externResLoader->addResourceTypes(
    array(
        'model' => array(
            'namespace' => 'Model',
            'path' => 'models'
        ),
        'mapper' => array(
            'namespace' => 'Model_Mapper',
            'path' => 'models/mappers'
        )
    ));

require_once '../../vendor/autoload.php';

/**
 * Zend_Application
 */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, 
        APPLICATION_PATH . '/configs/application.ini');
$application->bootstrap()->run();