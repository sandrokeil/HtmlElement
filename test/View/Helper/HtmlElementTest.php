<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace SakeTest\HtmlElement\View\Helper;

use Sake\HtmlElement\View\Helper\HtmlElement;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class HtmlElementTest
 *
 * Tests integrity of \SakeTest\HtmlElement\View\Helper\HtmlElement
 */
class HtmlElementTest extends TestCase
{
    /**
     * Tests send() with address balance request
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::setTag
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::getTag
     * @group view
     */
    public function testSetTag()
    {
        $cut = new HtmlElement();
        $tag = 'div';

        $cut->setTag($tag);

        $this->assertEquals($tag, $cut->getTag());
    }
}
