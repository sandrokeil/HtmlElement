<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\HtmlElement\Service;

use Sake\HtmlElement\View\Helper\HtmlElement;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

/**
 * HtmlElement view helper factory
 *
 * Creates html view helper and injects escaper
 */
class HtmlElementFactory implements FactoryInterface
{
    /**
     * Creates html view helper
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     * @param ServiceLocatorInterface $serviceLocator Service locator
     * @return HtmlElement
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $htmlElement = new HtmlElement();

        $htmlElement->setHelperEscapeHtmlAttr($serviceLocator->get('escapehtmlattr')->getEscaper());
        $htmlElement->setHelperEscapeHtml($serviceLocator->get('escapehtml')->getEscaper());
        return $htmlElement;
    }
}
