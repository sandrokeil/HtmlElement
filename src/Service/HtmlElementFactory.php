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
use Sake\EasyConfig\Service\AbstractConfigurableFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * HtmlElement view helper factory
 *
 * Creates html view helper and injects escaper
 */
class HtmlElementFactory extends AbstractConfigurableFactory
{
    /**
     * Config name
     *
     * @var string
     */
    protected $name;

    /**
     * Initialize object with config key name
     *
     * @param string $name Config name
     */
    public function __construct($name = 'default')
    {
        $this->name = $name;
    }

    /**
     * Creates html view helper
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     * @param ServiceLocatorInterface $serviceLocator Service locator
     * @return HtmlElement
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $this->getOptions($serviceLocator);

        $htmlElement = new HtmlElement();

        if (isset($options['escapeHtmlAttribute'])) {
            $htmlElement->setEscapeHtmlAttribute($options['escapeHtmlAttribute']);
        }

        if (isset($options['escapeText'])) {
            $htmlElement->setEscapeText($options['escapeText']);
        }

        if ($htmlElement->isEscapeText()
            || $htmlElement->isEscapeHtmlAttribute()
        ) {
            $htmlElement->setEscaper($serviceLocator->get('viewhelpermanager')->get('escapehtml')->getEscaper());
        }
        return $htmlElement;
    }

    /**
     * Module name
     *
     * @return string
     */
    public function getModule()
    {
        return 'sake_htmlelement';
    }

    /**
     * Config scope
     *
     * @return string
     */
    public function getScope()
    {
        return 'view_helper';
    }

    /**
     * Config name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
