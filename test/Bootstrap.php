<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014-2017 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace SakeTest\HtmlElement;

// set error reporting
error_reporting(E_ALL | E_STRICT);

chdir(dirname(__DIR__));

if (!file_exists('vendor/autoload.php')) {
    throw new \RuntimeException(
        'Unable to load ZF2. Run `php composer.phar install`'
    );
}

// Setup autoloading
include 'vendor/autoload.php';
