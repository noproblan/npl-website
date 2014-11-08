<?php

class GalleryController extends Zend_Controller_Action
{
	/**
	 * @var Application_Model_Mapper_AlbumsMapper
	 */
	protected $_albumsMapper = null;
	protected $_flashMessenger = null;
	protected $_instantMessenger = null;
	protected $_stripFilter = null;
	protected $_digitValidator = null;
	protected $_albumIDValidator = null;
	private $image_types = array(
			'gif' => 'image/gif',
			'png' => 'image/png',
			'jpg' => 'image/jpeg',
	);
	
	const GALLERY_PATH = "img/gallery/";
	
	const MSG_ALBUMID_INVALID = "Die angegebene Album ID ist ungültig.";
	const MSG_REQUEST_INVALID = "Die Anfrage ist ungültig.";
	
	public function init()
	{
		// Models
		$this->_albumsMapper = new Application_Model_Mapper_AlbumsMapper();
		// Messengers
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->_instantMessenger = new Npl_Helper_InstantMessenger();
		// Filters
		$this->_stripFilter = new Zend_Filter_StripTags();
		// Validators
		$this->_digitValidator = new Zend_Validate_Digits();
		$this->_albumIDValidator = new Zend_Validate_Db_RecordExists(
			array (
				'table' => 'npl_gal_albums',
				'field' => 'id'
			)
		);
	}
	
	/**
	 * Name:		Index
	 * Description:	Redirects to list of albums
	 * Access:		Guests, Members
	 */
	public function indexAction()
	{
		return $this->_helper->redirector('list');
	}
	
	/**
	 * Name:		List
	 * Description:	List all albums
	 * Access:		Guests, Members
	 */
	public function listAction()
	{
		$dbAlbums = $this->_albumsMapper->fetchAllDesc();
		$albums = array();
		foreach ($dbAlbums as $dbAlbum) {
			/* @var $dbAlbum Application_Model_Album */
			$album = array();
			$album['id'] = $dbAlbum->getId();
			$album['name'] = $dbAlbum->getName();
			$album['folder'] = $dbAlbum->getFolder();
			$path = self::GALLERY_PATH . $album['folder'];
			$counter = 0;
			if (file_exists($path)) {
				foreach (scandir($path) as $entry) {
					$entrypath = $path . '/' . $entry;
					if (!is_dir($entrypath)) {
						$finfo = new finfo();
						$fileinfo = $finfo->file($entrypath, FILEINFO_MIME_TYPE);
						if (in_array($fileinfo, $this->image_types)) {
							$counter++;
						}
					}
				}
			}
			$album['pictures'] = $counter;
			$albums[] = $album;
		}
		$this->view->albums = $albums;
		return;
	}
	
	/**
	 * Name: 		Show
	 * Description:	Shows all pictures from album
	 * Access:		Guests, Members
	 */
	public function albumAction()
	{
		$albumId = $this->getRequest()->getParam('id', null);
		if ($albumId != null) {
			$albumId = $this->_stripFilter->filter($albumId);
			if ($this->_digitValidator->isValid($albumId) &&
				$this->_albumIDValidator->isValid($albumId)) {
				$album = new Application_Model_Album();
				$this->_albumsMapper->find($albumId, $album);
				// TODO: Albuminhalt anzeigen
				$path = self::GALLERY_PATH . $album->getFolder();
				$pictures = array();
				if (file_exists($path)) {
					foreach (scandir($path) as $entry) {
						$entrypath = $path . '/' . $entry;
						if (!is_dir($entrypath)) {
							$picture['path'] = $entrypath;
							$picture['prev_path'] = $path . '/prev/' . $entry;
							$pictures[] = $picture;
						}
					}
				}
				$this->view->headLink()->appendStylesheet('/css/Lightbox.css');
				$this->view->album = $album->getName();
				$this->view->pictures = $pictures;
				return;
			} else {
				return $this->_instantMessenger->addError(self::MSG_ALBUMID_INVALID);
			}
		} else {
			return $this->_instantMessenger->addError(self::MSG_ALBUMID_INVALID);
		}
		return $this->_instantMessenger->addError(self::MSG_REQUEST_INVALID);
	}
}