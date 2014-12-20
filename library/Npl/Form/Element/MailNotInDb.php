<?php

class Npl_Form_Element_MailNotInDb extends Npl_Form_Element_Mail
{

    public function init ()
    {
        parent::init();
        $this->addValidators(
                array(
                        new Zend_Validate_Db_NoRecordExists(
                                array(
                                        'table' => 'npl_users',
                                        'field' => 'mail'
                                ))
                ));
    }
}