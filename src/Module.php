<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\HtmlElement;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * This class initializes the HtmlElement module.
 */
class Module implements ViewHelperProviderInterface, ConfigProviderInterface
{
    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array
     */
    public function getViewHelperConfig()
    {
        return require dirname(__DIR__) . '/config/view_helper.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array
     */
    public function getConfig()
    {
        return require dirname(__DIR__) . '/config/module.config.php';
    }
}
