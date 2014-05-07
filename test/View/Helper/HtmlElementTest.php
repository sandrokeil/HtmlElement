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
use Zend\View\HelperPluginManager;

/**
 * Class HtmlElementTest
 *
 * Tests integrity of \SakeTest\HtmlElement\View\Helper\HtmlElement
 */
class HtmlElementTest extends TestCase
{
    /**
     * PHP errors
     *
     * @var array
     */
    protected $errors = array();

    /**
     * Test error handler to get php errors
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * @param string $errcontext
     */
    public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
    {
        $this->errors[] = compact("errno", "errstr", "errfile", "errline", "errcontext");
    }

    /**
     * Checks if php error was occured
     *
     * @param int $errno
     * @param string $errstr
     * @return bool True if exists, otherwise false
     */
    public function hasError($errno, $errstr)
    {
        foreach ($this->errors as $error) {
            if (false !== strpos($error["errstr"], $errstr)
                && $error["errno"] === $errno) {
                return false;
            }
        }
        return true;
    }

    /**
     * Tests setTag
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

    /**
     * Tests setId
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::setId
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::getId
     * @group view
     */
    public function testSetId()
    {
        $cut = new HtmlElement();
        $id = 'unique';

        $cut->setId($id);

        $this->assertEquals($id, $cut->getId());
    }

    /**
     * Tests setClass
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::setClass
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::getClass
     * @group view
     */
    public function testSetClass()
    {
        $cut = new HtmlElement();
        $class = 'box shadow';

        $cut->setClass($class);

        $this->assertEquals($class, $cut->getClass());
    }

    /**
     * Tests appendClass
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::appendClass
     * @depends testSetClass
     * @group view
     */
    public function testAppendClass()
    {
        $cut = new HtmlElement();
        $class = 'box';
        $append = 'shadow';

        $cut->appendClass($append);
        $this->assertEquals($append, $cut->getClass());

        $cut->setClass($class);
        $cut->appendClass($append);

        $this->assertEquals($class . ' ' . $append, $cut->getClass());
    }

    /**
     * Tests setText
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::setText
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::getText
     * @group view
     */
    public function testSetText()
    {
        $cut = new HtmlElement();
        $test = 'my text';

        $cut->setText($test);

        $this->assertEquals($test, $cut->getText());
    }

    /**
     * Tests appendText
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::appendText
     * @depends testSetText
     * @group view
     */
    public function testAppendText()
    {
        $cut = new HtmlElement();
        $text = 'my text';
        $append = 'another text';

        $cut->appendText($append);
        $this->assertEquals($append, $cut->getText());

        $cut->setText($text);
        $cut->appendText($append);

        $this->assertEquals($text . $append, $cut->getText());
    }

    /**
     * Tests setAttributes
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::setAttributes
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::getAttributes
     * @group view
     */
    public function testSetAttributes()
    {
        $cut = new HtmlElement();

        $id = 'my id';
        $class = 'box';

        $cut->setId($id);
        $cut->setClass($class);

        $this->assertEquals(array('id' => $id, 'class' => $class), $cut->getAttributes());

        $attributes = array(
            'id' => 'unique',
            'class' => 'box shadow',
        );
        $cut->setAttributes($attributes);

        $this->assertEquals($attributes, $cut->getAttributes());
    }

    /**
     * Tests if html rendering can be enabled / disabled
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::enableHtml
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::useHtml
     * @group view
     */
    public function testToggleHtmlRendering()
    {
        $cut = new HtmlElement();

        $this->assertEquals(false, $cut->useHtml(), 'Html rendering is not disabled at default');

        $cut->enableHtml(true);
        $this->assertEquals(true, $cut->useHtml(), 'Html rendering can not be enabled');

        $cut->enableHtml(false);
        $this->assertEquals(false, $cut->useHtml(), 'Html rendering can not be disabled');
    }

    /**
     * Tests if call of view helper return new html element object with specified objects
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::__invoke
     * @depends testSetText
     * @depends testSetClass
     * @depends testToggleHtmlRendering
     * @group view
     */
    public function testInvokeShouldReturnObjectWithSpecifiedOptions()
    {
        $cut = new HtmlElement();

        $text = 'my text';
        $tag = 'div';
        $id = 'unique';
        $class = 'box shadow';
        $attributes = array('id' => $id, 'class' => $class);

        /* @var $element HtmlElement */
        $element = $cut($tag, $text, $attributes, true);

        $this->assertInstanceOf('\Sake\HtmlElement\View\Helper\HtmlElement', $element, "Invocation doesn't work");

        $this->assertEquals(true, $element->useHtml(), 'Html rendering was not enabled');
        $this->assertEquals($attributes, $element->getAttributes(), 'Html attributes were not set');
        $this->assertEquals($id, $element->getId(), 'Id attribute was not set');
        $this->assertEquals($class, $element->getClass(), 'Css class was not set');
    }

    /**
     * Tests if html element rendered successfully
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::render
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::buildAttributes
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::__toString
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::toString
     * @depends testInvokeShouldReturnObjectWithSpecifiedOptions
     * @group view
     */
    public function testToStringShouldTriggerErrorIfExceptionOccurs()
    {
        $this->errors = array();
        set_error_handler(array($this, "errorHandler"));

        $stub = $this->getStubWithViewPluginManager(true);

        $text = 'my text';
        $tag = 'div';
        $id = 'unique';
        $class = 'box shadow';
        $attributes = array(array('id' => $id, 'class' => $class));

        /* @var $element HtmlElement */
        $element = $stub($tag, $text, $attributes);
        $html = (string) $element;

        $this->assertFalse(
            $this->hasError(E_USER_WARNING, 'Array provided'),
            sprintf('Error "%s" with message "%s" was not found', E_USER_WARNING, 'Array provided')
        );
    }

    /**
     * Tests if html element rendered successfully
     *
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::render
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::buildAttributes
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::__toString
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::toString
     * @depends testInvokeShouldReturnObjectWithSpecifiedOptions
     * @group view
     */
    public function testRender()
    {
        $stub = $this->getStubWithViewPluginManager();

        $text = 'my text';
        $tag = 'div';
        $id = 'unique';
        $class = 'box shadow';
        $attributes = array('id' => $id, 'class' => $class);

        $expectedHtml = '<div id="unique" class="box shadow">my text</div>';

        /* @var $element HtmlElement */
        $element = $stub($tag, $text, $attributes);

        $this->assertEquals($expectedHtml, $element->render(), 'Html element rendering failed');
        $this->assertEquals($expectedHtml, $element->__toString(), 'Html element rendering failed');
        $this->assertEquals($expectedHtml, $element->toString(), 'Html element rendering failed');

        $element->enableHtml(true);
        $this->assertEquals($expectedHtml, $element->render(), 'Html element rendering failed');
    }

    /**
     * Tests if html element rendered self closing tag successfully
     *
     * @depends testInvokeShouldReturnObjectWithSpecifiedOptions
     * @dataProvider dataProviderForTestRenderWithSelfClosingTag
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::render
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::buildAttributes
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::__toString
     * @covers \Sake\HtmlElement\View\Helper\HtmlElement::toString
     * @group view
     */
    public function testRenderWithSelfClosingTag($tag)
    {
        $stub = $this->getStubWithViewPluginManager();

        // text should not be rendered
        $text = 'my text';
        $id = 'unique';
        $class = 'full';
        $attributes = array('id' => $id, 'class' => $class);

        $expectedHtml = '<' . $tag . ' id="unique" class="full" />';

        /* @var $element HtmlElement */
        $element = $stub($tag, $text, $attributes);

        $this->assertEquals($expectedHtml, $element->render(), 'Html element rendering failed');
        $this->assertEquals($expectedHtml, $element->__toString(), 'Html element rendering failed');
        $this->assertEquals($expectedHtml, $element->toString(), 'Html element rendering failed');
    }

    /**
     * Returns stub with mocked view plugin manager
     *
     * @param bool $realPluginmanager
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getStubWithViewPluginManager($realPluginmanager = false)
    {
        $stub = $this->getMock('Sake\HtmlElement\View\Helper\HtmlElement', array('getView', 'plugin'));

        // maybe there is a better way to do this, but at the moment it works
        $callback = function ($name) use ($realPluginmanager) {
            if ($realPluginmanager) {
                $plugin = new HelperPluginManager();
                return $plugin->get($name);
            }
            return function ($value) {
                return $value;
            };
        };

        $stub->expects($this->any())
            ->method('getView')
            ->will($this->returnSelf());

        $stub->expects($this->any())
            ->method('plugin')
            ->will($this->returnCallback($callback));

        return $stub;
    }

    /**
     * data provider for the test method testRenderWithSelfClosingTag()
     *
     * @return array
     */
    public function dataProviderForTestRenderWithSelfClosingTag()
    {
        return array(
            array(
                'tag' => 'area',
            ),
            array(
                'tag' => 'base',
            ),
            array(
                'tag' => 'br',
            ),
            array(
                'tag' => 'col',
            ),
            array(
                'tag' => 'command',
            ),
            array(
                'tag' => 'embed',
            ),
            array(
                'tag' => 'hr',
            ),
            array(
                'tag' => 'img',
            ),
            array(
                'tag' => 'input',
            ),
            array(
                'tag' => 'keygen',
            ),
            array(
                'tag' => 'link',
            ),
            array(
                'tag' => 'meta',
            ),
            array(
                'tag' => 'param',
            ),
            array(
                'tag' => 'source',
            ),
            array(
                'tag' => 'track',
            ),
            array(
                'tag' => 'wbr',
            ),
        );
    }
}
