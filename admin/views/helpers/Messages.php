<?php

class Zend_View_Helper_Messages extends Zend_View_Helper_Abstract
{
	
	public function messages()
	{
		$html = '';
		
		$html = $this->addErrors($html);
		$html = $this->addNotices($html);
		$html = $this->addSuccesses($html);
	
		if ($html != '') {
			$html = $this->addWrapper($html);
		}
	
		return $html;
	}
	
	private function addSuccesses($html)
	{
		$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$instantMessenger = new Npl_Helper_InstantMessenger();
		
		if ($flashMessenger->setNamespace('success')->hasMessages() ||
				$instantMessenger->hasSuccesses()) {
			$html .= '<div class="messages-success">';
			if ($flashMessenger->setNamespace('success')->hasMessages()) {
				foreach ($flashMessenger->getMessages() as $message) {
					$html = $this->addMessage($html, $message, 'success');
				}
			}
			if ($instantMessenger->hasSuccesses()) {
				foreach ($instantMessenger->removeSuccesses() as $message) {
					$html = $this->addMessage($html, $message, 'success');
				}
			}
			$html .= '</div>';
		}
		return $html;
	}
	
	private function addNotices($html)
	{
		$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$instantMessenger = new Npl_Helper_InstantMessenger();
	
		if ($flashMessenger->setNamespace('notice')->hasMessages() ||
				$instantMessenger->hasNotices()) {
			$html .= '<div class="messages-notice">';
			if ($flashMessenger->setNamespace('notice')->hasMessages()) {
				foreach ($flashMessenger->getMessages() as $message) {
					$html = $this->addMessage($html, $message, 'notice');
				}
			}
			if ($instantMessenger->hasNotices()) {
				foreach ($instantMessenger->removeNotices() as $message) {
					$html = $this->addMessage($html, $message, 'notice');
				}
			}
			$html .= '</div>';
		}
		return $html;
	}
	
	private function addErrors($html)
	{
		$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$instantMessenger = new Npl_Helper_InstantMessenger();
	
		if ($flashMessenger->setNamespace('error')->hasMessages() ||
				$instantMessenger->hasErrors()) {
			$html .= '<div class="messages-error">';
			if ($flashMessenger->setNamespace('error')->hasMessages()) {
				foreach ($flashMessenger->getMessages() as $message) {
					$html = $this->addMessage($html, $message, 'error');
				}
			}
			if ($instantMessenger->hasErrors()) {
				foreach ($instantMessenger->removeErrors() as $message) {
					$html = $this->addMessage($html, $message, 'error');
				}
			}
			$html .= '</div>';
		}
		return $html;
	}
	
	private function addWrapper($html)
	{
		$html = '<div>' . $html;
		$html .= '</div>';
		return $html;
	}
	
	private function addMessage($html, $message, $type)
	{
		$html .= '<div class="message-' . $type . '">';
		$html .= $message;
		$html .= '</div>';
		return $html;
	}
}