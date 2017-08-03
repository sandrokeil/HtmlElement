<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014-2017 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\HtmlElement\Service;

use Sake\HtmlElement\View\Helper\HtmlElement;
use Interop\Config\ConfigurationTrait;
use Interop\Config\ProvidesDefaultOptions;
use Interop\Config\RequiresConfigId;
use Interop\Container\ContainerInterface;

/**
 * HtmlElement view helper factory
 *
 * Creates html view helper and injects escaper
 */
class HtmlElementFactory implements ProvidesDefaultOptions, RequiresConfigId
{

    use ConfigurationTrait;

    /**
     * @var string
     */
    private $configId;

    /**
     * Creates a new instance from a specified config, specifically meant to be used as static factory.
     *
     * In case you want to use another config key than provided by the factories, you can add the following factory to
     * your config:
     *
     * <code>
     * <?php
     * return [
     *     HtmlElement::class => [HtmlElementFactory::class, 'service_name'],
     * ];
     * </code>
     *
     * @throws \InvalidArgumentException
     */
    public static function __callStatic(string $name, array $arguments): HtmlElement
    {
        if (! isset($arguments[0]) || ! $arguments[0] instanceof ContainerInterface) {
            throw new \InvalidArgumentException(
                sprintf('The first argument must be of type %s', ContainerInterface::class)
            );
        }

        return (new static($name))->__invoke($arguments[0]);
    }

    public function __invoke(ContainerInterface $container): HtmlElement
    {
        $config = $container->get('config');
        $config = $this->options($config, $this->configId);

        $htmlElement = new HtmlElement();

        if (isset($config['escapeHtmlAttribute'])) {
            $htmlElement->setEscapeHtmlAttribute($config['escapeHtmlAttribute']);
        }

        if (isset($config['escapeText'])) {
            $htmlElement->setEscapeText($config['escapeText']);
        }

        return $htmlElement;
    }

    public function __construct(string $configId = 'default')
    {
        $this->configId = $configId;
    }

    public function dimensions(): iterable
    {
        return ['sake_htmlelement', 'view_helper'];
    }

    public function defaultOptions(): iterable
    {
        return [
            'escapeHtmlAttribute' => true,
            'escapeText' => true,
        ];
    }
}
