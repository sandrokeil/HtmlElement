<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014-2017 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace SakeTest\HtmlElement\Service;

use PHPUnit\Framework\TestCase;
use Sake\HtmlElement\Service\HtmlElementFactory;
use Sake\HtmlElement\View\Helper\HtmlElement;

/**
 * Class HtmlElementFactory
 *
 * Tests integrity of \SakeTest\HtmlElement\Service\HtmlElementFactory
 */
class HtmlElementFactoryTest extends TestCase
{
    /**
     * Tests createService() returns a valid and configured service instance.
     *
     * @covers \Sake\HtmlElement\Service\HtmlElementFactory
     * @group factory
     */
    public function testCreateService()
    {
        $config = [
            'sake_htmlelement' => [
                'view_helper' => [
                    'default' => [
                        'escapeHtmlAttribute' => true,
                        'escapeText' => true,
                    ],
                ],
            ],
        ];

        $container = $this->prophesize(\Interop\Container\ContainerInterface::class);

        $container->get('config')->willReturn($config)->shouldBeCalled();

        $factory = new HtmlElementFactory();
        $htmlElement = $factory($container->reveal());

        $this->assertInstanceOf(HtmlElement::class, $htmlElement);
    }
}
