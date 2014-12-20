<?php

class Zend_View_Helper_RandomGalleryPics extends Zend_View_Helper_Abstract
{

    private $imageTypes = array(
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpg' => 'image/jpeg'
    );

    const GALLERY_PATH = "img/gallery/";

    /**
     * Holt zufällig aus der Gallerie ein paar Bilder
     * TODO: ein bisschen wahnsinnig, für jeden Seitenaufruf dermassen viele
     * Festplattenzugriffe...
     * 
     * @param $count Anzahl
     *            der Bilder
     */
    public function randomGalleryPics ($count)
    {
        $randPics = array();
        if (file_exists(self::GALLERY_PATH)) {
            $galleries = scandir(self::GALLERY_PATH);
            unset($galleries[0]); // "."
            unset($galleries[1]); // ".."
            
            $counter = 0;
            while ($counter <= $count) {
                // wähle eine Galerie zufällig aus
                $galleryDir = $galleries[array_rand($galleries)];
                if (! empty($galleryDir)) {
                    // liste alle Bilder mit gewissem Typ
                    $fileNames = array();
                    foreach ($this->imageTypes as $imgType => $mimeType) {
                        $fileNamesWithType = glob(
                                self::GALLERY_PATH . $galleryDir . "/*." .
                                         $imgType);
                        if (! empty($fileNamesWithType)) {
                            $fileNames = array_merge($fileNames, 
                                    $fileNamesWithType);
                        }
                    }
                    // wähle eines zufällig aus
                    if (! empty($fileNames)) {
                        $randPic = $fileNames[array_rand($fileNames)];
                    }
                    if (! empty($randPic)) {
                        $randPics[] = $randPic;
                    }
                }
                $counter ++;
            }
        }
        return $randPics;
    }
}