<?php

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {
    $framework->session()
        ->enabled(true)
        ->handlerId(null)
        ->cookieSecure('auto')
        ->cookieSamesite(Cookie::SAMESITE_LAX)
        ->storageFactoryId('session.storage.factory.native');
};
