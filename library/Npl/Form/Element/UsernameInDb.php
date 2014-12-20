<?php

class Npl_Form_Element_UsernameInDb extends Npl_Form_Element_Username
{

    public function init ()
    {
        parent::init();
        $this->addValidators(
                array(
                        new Zend_Validate_Db_RecordExists(
                                array(
                                        'table' => 'npl_users',
                                        'field' => 'username'
                                ))
                ));
    }
}