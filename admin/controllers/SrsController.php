<?php

class SrsController extends Zend_Controller_Action
{

    public function init ()
    {
        $this->_helper->ajaxContext()
            ->addActionContext('ajaxsave', 'json')
            ->addActionContext('ajaxremove', 'json')
            ->initContext();
    }

    public function indexAction ()
    {}

    public function editAction ()
    {
        $id = $this->getRequest()->getParam('map', 0);
        $mapsMapper = new Application_Model_Mapper_MapsMapper();
        $maps = $mapsMapper->fetchAll();
        
        $this->view->map = new Application_Model_Map(
                array(
                        "name" => "new",
                        "lanId" => 0
                ));
        $this->view->desks = array();
        $this->view->mapIndexes = array();
        foreach ($maps as $map) {
            /* @var $map Application_Model_Map */
            $this->view->mapIndexes[] = array(
                    "id" => $map->getId(),
                    "name" => $map->getName()
            );
            if ($id == $map->getId()) {
                $this->view->map = $map;
                $this->view->desks = $map->getDesks();
            }
        }
    }

    public function ajaxsaveAction ()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
        
        $mapToSave = $this->getRequest()->getParam('map', null);
        $desksToSave = $this->getRequest()->getParam('desks', null);
        
        $mapsMapper = new Application_Model_Mapper_MapsMapper();
        $mapModel = new Application_Model_Map(
                array(
                        "color" => "000000",
                        "height" => 1000,
                        "width" => 2000
                ));
        
        $mapsMapper->find($mapToSave["id"], $mapModel);
        $mapModel->setName($mapToSave["name"]);
        $mapsMapper->save($mapModel);
        
        $desksMapper = new Application_Model_Mapper_DesksMapper();
        $desks = $desksMapper->fetchAllByMapId($mapModel->getId());
        foreach ($desksToSave as $deskToSave) {
            $desk = new Application_Model_Desk(
                    array(
                            "deskTypeId" => 1,
                            "height" => 80,
                            "width" => 180,
                            "active" => 1
                    ));
            $desksMapper->find($deskToSave["id"], $desk);
            $desk->setMapId($mapModel->getId());
            $desk->setPositionX($deskToSave["x"]);
            $desk->setPositionY($deskToSave["y"]);
            $desk->setRotation($deskToSave["rotation"]);
            $desksMapper->save($desk);
            
            $seatsMapper = new Application_Model_Mapper_SeatsMapper();
            
            // kein linker Sitz
            if ($deskToSave["seats"]["leftseat"] == "false") {
                foreach ($desk->getSeats() as $seat) {
                    /* @var $seat Application_Model_Seat */
                    if ($seat->getSeatPositionId() == 1) {
                        $seatsMapper->delete($seat);
                    }
                }
            }
            
            // kein rechter Sitz
            if ($deskToSave["seats"]["rightseat"] == "false") {
                foreach ($desk->getSeats() as $seat) {
                    /* @var $seat Application_Model_Seat */
                    if ($seat->getSeatPositionId() == 2) {
                        $seatsMapper->delete($seat);
                    }
                }
            }
            
            // ein neuer linker Sitz
            if ($deskToSave["seats"]["leftseat"] == "true") {
                // lösche alle linken Sitze
                foreach ($desk->getSeats() as $seat) {
                    /* @var $seat Application_Model_Seat */
                    if ($seat->getSeatPositionId() == 1) {
                        $seatsMapper->delete($seat);
                    }
                }
                $newSeat = new Application_Model_Seat(
                        array(
                                "active" => true,
                                "deskId" => $desk->getId(),
                                "seatPositionId" => 1,
                                "name" => $desk->getId()
                        ));
                $seatsMapper->save($newSeat);
            }
            
            // ein neuer rechter Sitz
            if ($deskToSave["seats"]["rightseat"] == "true") {
                // lösche alle rechten Sitze
                foreach ($desk->getSeats() as $seat) {
                    /* @var $seat Application_Model_Seat */
                    if ($seat->getSeatPositionId() == 2) {
                        $seatsMapper->delete($seat);
                    }
                }
                $newSeat = new Application_Model_Seat(
                        array(
                                "active" => true,
                                "deskId" => $desk->getId(),
                                "seatPositionId" => 2,
                                "name" => $desk->getId()
                        ));
                $seatsMapper->save($newSeat);
            }
        }
        
        echo json_encode($mapModel->getId());
    }

    public function ajaxremoveAction ()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
        
        $deskIdToDel = $this->getRequest()->getParam('desk', null);
        if (isset($deskIdToDel)) {
            $desksMapper = new Application_Model_Mapper_DesksMapper();
            $deskModel = new Application_Model_Desk();
            $desksMapper->find($deskIdToDel, $deskModel);
            $desksMapper->delete($deskModel);
        }
    }
}

