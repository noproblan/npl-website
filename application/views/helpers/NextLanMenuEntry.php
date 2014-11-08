<?php

class Zend_View_Helper_NextLanMenuEntry extends Zend_View_Helper_Abstract
{
	public function nextLanMenuEntry()
	{
		$mapper = new Application_Model_Mapper_LansMapper();
		$comingLans = $mapper->fetchComing();
		if (isset($comingLans[0])) {
			/* @var $lan Application_Model_Lan */
			$lan = $comingLans[0];
			$lanId = $lan->getId();
			$lanName = $lan->getName();
			
			$html = '<div class="navigation-item">
			<a href="';
			$html .= $this->view->url(
				array(
					'controller' => 'lan',
					'action' => 'info',
					'lanid' => $lanId,
				),
				'default',
				true
			);
			$html .= '">';
			$html .= $lanName;
			$html .= '</a>';
			$html .= '</div>';
			return $html;
		}
	}
}