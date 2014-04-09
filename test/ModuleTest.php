<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace SakeTest\HtmlElement;

use \Sake\HtmlElement\Module;

/**
 * Class ModuleTest
 *
 * Tests integrity of \Sake\HtmlElement\Module
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getViewHelperConfig() should should return view helper configuration
     *
     * @covers \Sake\HtmlElement\Module::getViewHelperConfig
     */
    public function testGetServiceConfig()
    {
        $cut = new Module();
        $config = $cut->getViewHelperConfig();
        $this->assertSame(
            @include 'config/view_helper.config.php',
            $config,
            'View helper configuration could not be read'
        );
    }
}
