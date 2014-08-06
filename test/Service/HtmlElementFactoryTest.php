<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace SakeTest\HtmlElement\Service;

use \Sake\HtmlElement\Service\HtmlElementFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Test\Util\ModuleLoader;

/**
 * Class HtmlElementFactory
 *
 * Tests integrity of \SakeTest\HtmlElement\Service\HtmlElementFactory
 */
class HtmlElementFactoryTest extends TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var ModuleLoader
     */
    protected $moduleLoader;

    /**
     * Setup tests
     */
    public function setUp()
    {
        parent::setUp();

        // Load the user-defined test configuration file, if it exists; otherwise, load default
        if (is_readable('test/TestConfig.php')) {
            $testConfig = require 'test/TestConfig.php';
        } else {
            $testConfig = require 'test/TestConfig.php.dist';
        }
        $this->moduleLoader = new ModuleLoader($testConfig);
        $this->serviceManager = $this->moduleLoader->getServiceManager();
    }

    /**
     * Tests createService() returns a valid and configured service instance.
     *
     * @covers \Sake\HtmlElement\Service\HtmlElementFactory::createService
     * @covers \Sake\HtmlElement\Service\HtmlElementFactory::__construct
     * @covers \Sake\HtmlElement\Service\HtmlElementFactory::getModule
     * @covers \Sake\HtmlElement\Service\HtmlElementFactory::getScope
     * @covers \Sake\HtmlElement\Service\HtmlElementFactory::getName
     * @group factory
     */
    public function testCreateService()
    {
        $factory = new HtmlElementFactory();

        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $factory);

        /* @var $service \Sake\HtmlElement\Service\HtmlElementFactory */
        $service = $factory->createService($this->serviceManager->get('viewhelpermanager'));
        $this->assertInstanceOf(
            '\Sake\HtmlElement\View\Helper\HtmlElement',
            $service,
            'Factory could not create HtmlElement view helper'
        );
    }
}
