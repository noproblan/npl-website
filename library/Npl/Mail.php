<?php

/**
 * @see Zend_Db_Table_Abstract
 */
require_once 'Zend/Mail.php';

/**
 *
 * Enter description here ...
 * 
 * @author chuvisco
 */
class Npl_Mail
{

    protected $_viewSubject;

    protected $_viewContent;

    protected $templateVariables = array();

    protected $templateName;

    protected $templatePath = null;

    protected $_mail;

    protected $recipient;

    protected $recipientName;

    public function __construct ($charset = null)
    {
        $this->_mail = new Zend_Mail($charset);
        $this->_viewSubject = new Zend_View();
        $this->_viewContent = new Zend_View();
    }

    /**
     * Set variables for use in the templates
     *
     * @param string $name
     *            The name of the variable to be stored
     * @param mixed $value
     *            The value of the variable
     */
    public function __set ($name, $value)
    {
        $this->templateVariables[$name] = $value;
    }

    /**
     * Set the template file to use
     *
     * @param string $filename
     *            Template filename
     */
    public function setTemplate ($filename)
    {
        $this->templateName = $filename;
    }

    /**
     * Set the recipient address for the mail message
     *
     * @param string $mail
     *            Mail address
     */
    public function setRecipient ($mail, $name = null)
    {
        $this->recipient = $mail;
        if (is_null($name))
            $name = $mail;
        $this->recipientName = $name;
    }

    /**
     * Set the from address for the mail message
     *
     * @param string $mail
     *            Mail address
     */
    public function setFrom ($mail, $name = null)
    {
        $this->_mail->setFrom($mail, $name);
    }

    /**
     * Set the template path for the mail message
     *
     * @param string $path
     *            Path to mail template
     */
    public function setTemplatePath ($path)
    {
        $this->templatePath = $path;
    }

    /**
     * Send mail
     */
    public function send ()
    {
        if (is_null($this->templatePath))
            throw new Exception("No mail template path");
        $mailPath = $this->templatePath;
        
        $viewSubject = $this->_viewSubject->setScriptPath($mailPath);
        foreach ($this->templateVariables as $key => $value) {
            $viewSubject->{$key} = $value;
        }
        $subject = $viewSubject->render($this->templateName . '.subj.tpl');
        
        $viewContent = $this->_viewContent->setScriptPath($mailPath);
        foreach ($this->templateVariables as $key => $value) {
            $viewContent->{$key} = $value;
        }
        $html = $viewContent->render($this->templateName . '.tpl');
        
        $this->_mail->addTo($this->recipient, $this->recipientName);
        $this->_mail->setSubject($subject);
        $this->_mail->setBodyHtml($html);
        
        $this->_mail->send();
    }
}