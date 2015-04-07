<?php

class IndexController extends Zend_Controller_Action
{

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        return $this->_forward('list', 'news');
    }

    public function aboutAction() {

    }

    public function contactAction() {

    }

    public function sitemapAction() {
        // XML-related routine
        $xml = new DOMDocument('1.0', 'utf-8');

        $navigation = new Zend_Navigation();

        // HOME
        $home = new Zend_Navigation_Page_Mvc(array(
            'label' => 'Home',
            'action' => 'index',
            'controller' => 'index'
        ));
        $navigation->addPage($home);

        $lanPartiesSubpages = array();

        // NEXT LAN
        $lansMapper = new Application_Model_Mapper_LansMapper();
        $comingLans = $lansMapper->fetchComing();
        if (isset($comingLans[0])) {
            /* @var $lan Application_Model_Lan */
            $lan = $comingLans[0];
            $nextLan = new Zend_Navigation_Page_Mvc(array(
                'label' => $lan->getName(),
                'action' => 'info',
                'controller' => 'lan',
                'params' => array(
                    'lanid' => $lan->getId()
                )
            ));
            $navigation->addPage($nextLan);
            $lanPartiesSubpages[] = array(
                'label' => $lan->getName(),
                'action' => 'info',
                'controller' => 'lan',
                'params' => array(
                    'lanid' => $lan->getId()
                )
            );
        }

        $galleryArray = array(
            'label' => 'Galerie',
            'action' => 'index',
            'controller' => 'gallery'
        );

        // LANPARTIES
        $lanPartiesSubpages[] = $galleryArray;
        $lanParties = new Zend_Navigation_Page_Mvc(array(
            'label' => 'LAN-Parties',
            'action' => 'index',
            'controller' => 'lan',
            'pages' => $lanPartiesSubpages
        ));
        $navigation->addPage($lanParties);

        // GALLERY
        $albumMapper = new Application_Model_Mapper_AlbumsMapper();
        $albums = $albumMapper->fetchAllDesc();
        $albumArray = array();
        foreach ($albums as $album) {
            $albumArray[] = array(
                'label' => $album->getName(),
                'action' => 'album',
                'controller' => 'gallery',
                'params' => array(
                    'id' => $album->getId()
                )
            );
        }
        $galleryArray['pages'] = $albumArray;
        $gallery = new Zend_Navigation_Page_Mvc($galleryArray);
        $navigation->addPage($gallery);

        // SPONSORS
        $sponsorMapper = new Application_Model_Mapper_SponsorsMapper();
        $sponsors = $sponsorMapper->fetchAll();
        $sponsorArray = array();
        foreach ($sponsors as $sponsor) {
            $sponsorArray[] = array(
                'label' => $sponsor->getName(),
                'uri' => $sponsor->getLink()
            );
        }
        $sponsor = new Zend_Navigation_Page_Mvc(array(
            'label' => 'Sponsoren',
            'action' => 'index',
            'controller' => 'sponsor',
            'pages' => $sponsorArray
        ));
        $navigation->addPage($sponsor);

        // "FORUM"
        $forum = new Zend_Navigation_Page_Uri(array(
            'uri' => 'https://www.facebook.com/noproblan'
        ));
        $navigation->addPage($forum);

        // ABOUT
        $about = new Zend_Navigation_Page_Mvc(array(
            'label' => 'Über uns',
            'action' => 'about',
            'controller' => 'index'
        ));
        $navigation->addPage($about);

        // CONTACT
        $contact = new Zend_Navigation_Page_Mvc(array(
            'label' => 'Kontakt',
            'action' => 'contact',
            'controller' => 'index'
        ));
        $navigation->addPage($contact);

        $this->view->navigation($navigation);
        $this->view->navigation()->sitemap()->setFormatOutput(true)
            ->setUseSchemaValidation(false)
            ->setUseXmlDeclaration(true)
            ->setUseSitemapValidators(true);
        echo $this->view->navigation()->sitemap()->render();


        // Both layout and view renderer should be disabled
        Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->setNoRender(true);
        Zend_Layout::getMvcInstance()->disableLayout();

        // Set up headers and body
        $this->_response->setHeader('Content-Type', 'text/xml; charset=utf-8');
    }
}

