<?php

class Application_Form_TicketExtras extends Npl_TableForm
{

    public function init ()
    {
        $this->setAttrib('id', 'ticketExtras');
        $this->setAction('');
        $this->setMethod('post');

        $checkBreakfast = new Zend_Form_Element_Checkbox('breakfast');
        $checkBreakfast->setLabel('Frühstück Sa & So (5 CHF)');
        $checkDinner = new Zend_Form_Element_Checkbox('dinner');
        $checkDinner->setLabel('Abendessen Fr & Sa (15 CHF)');
        /*
         * $checkCable = new Zend_Form_Element_Checkbox('cable');
         * $checkCable->setLabel('Zusätzliches LAN-Kabel (10 CHF)');
         */
        $checkHelping = new Zend_Form_Element_Checkbox('helping');
        $checkHelping->setLabel('Ich möchte gerne helfen');
        $ticketId = new Zend_Form_Element_Hidden('ticketId');
        $save = new Zend_Form_Element_Submit('submit',
                array(
                        'class' => 'button',
                        'required' => false,
                        'ignore' => true,
                        'label' => 'Speichern'
                ));

        $this->addElement($checkBreakfast);
        $this->addElement($checkDinner);
        // $this->addElement($checkCable);
        $this->addElement($checkHelping);
        $this->addElement($ticketId);
        $this->addElement($save);
    }
}