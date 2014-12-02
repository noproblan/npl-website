<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction ()
    {
        $errors = $this->_getParam('error_handler');
        if (! $errors || ! $errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Page not found';
                break;
            default:
                
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception
        /* @var $exception Zend_Controller_Action_Exception */
        $exception = $errors->exception;
        /* @var $errorLogger Zend_Log */
        $errorLogger = Zend_Registry::get('errorLogger');
        $errorLogger->setEventItem("userIp", 
                $errors->request->getServer('REMOTE_ADDR'));
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $errorLogger->setEventItem("userName", 
                    Zend_Auth::getInstance()->getIdentity()->username);
        } else {
            $errorLogger->setEventItem("userName", "guest");
        }
        $errorLogger->setEventItem("url", $this->_getAbsoluteRequestURI());
        $requestParams = $this->_filterPasswordRequests(
                $errors->request->getParams());
        $errorLogger->setEventItem("params", json_encode($requestParams));
        $errorLogger->setEventItem("file", $exception->getFile());
        $errorLogger->setEventItem("line", $exception->getLine());
        $errorLogger->log($exception->getMessage(), $priority);
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request = $errors->request;
    }

    public function noaccessAction ()
    {
        $this->getResponse()->setHttpResponseCode(403);
        // Log noaccess
        $priority = Zend_Log::NOTICE;
        /* @var $errorLogger Zend_Log */
        $errorLogger = Zend_Registry::get('errorLogger');
        $errorLogger->setEventItem("userIp", 
                $this->getRequest()
                    ->getServer('REMOTE_ADDR'));
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $errorLogger->setEventItem("userName", 
                    Zend_Auth::getInstance()->getIdentity()->username);
        } else {
            $errorLogger->setEventItem("userName", "guest");
        }
        $errorLogger->setEventItem("url", $this->_getAbsoluteRequestURI());
        $requestParams = $this->_filterPasswordRequests(
                $this->getRequest()
                    ->getParams());
        $errorLogger->setEventItem("params", json_encode($requestParams));
        $errorLogger->setEventItem("file", "");
        $errorLogger->setEventItem("line", "");
        $errorLogger->log("403", $priority);
    }

    /**
     * Gets the absolute request uri
     *
     * @return string
     */
    private function _getAbsoluteRequestURI ()
    {
        return $this->getRequest()->getScheme() . '://' .
                 $this->getRequest()->getHttpHost() .
                 $this->getRequest()->getRequestUri();
    }

    /**
     * Replaces passwords with stars
     *
     * @return array
     */
    private function _filterPasswordRequests ($requestArray)
    {
        foreach ($requestArray as $key => $value) {
            if (strcasecmp($key, "password") === 0) {
                $requestArray[$key] = "****";
            }
            if (strcasecmp($key, "passwordConfirm") === 0) {
                $requestArray[$key] = "****";
            }
        }
        return $requestArray;
    }
}

