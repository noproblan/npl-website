<?php

class Zend_View_Helper_RandomGalleryPics extends Zend_View_Helper_Abstract
{

    private $imageTypes = array(
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpg' => 'image/jpeg'
    );

    const GALLERIES_PATH = "img/gallery/";

    /**
     * Holt zufällig aus der Gallerie ein paar Bilder
     * TODO: ein bisschen wahnsinnig, für jeden Seitenaufruf dermassen viele
     * Festplattenzugriffe...
     * 
     * @param $count Anzahl
     *            der Bilder
     */
    public function randomGalleryPics($count)
    {
        $randomPictures = array();
        if (file_exists(self::GALLERIES_PATH)) {
            $galleries = scandir(self::GALLERIES_PATH);
            unset($galleries[0]); unset($galleries[1]);
            $galleries = array_values($galleries); // reindex to be sure

            if (empty($galleries)) return []; // break if no subfolders are present
            
            $i = 0;
            while ($i++ < $count) {
                $randomIndex = mt_rand(0, count($galleries) - 1);
                $randomGalleryPath = $galleries[$randomIndex];
                $randomPicture = $this->_chooseRandomImage($randomGalleryPath);
                if ($randomPicture) $randomPictures[] = $randomPicture;
            }
        }
        return $randomPictures;
    }

    private function _chooseRandomImage($galleryPath) {
        $path = self::GALLERIES_PATH . "$galleryPath/*.{jpeg,jpg,gif,png,JPEG,JPG,GIF,PNG}";
        $pictures = glob($path, GLOB_BRACE);
        if (empty($pictures)) return null;
        $randomIndex = mt_rand(0, count($pictures) - 1);
        return $pictures[$randomIndex];
    }
}

