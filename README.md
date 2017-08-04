# HtmlElement view helper for Zend Framework

> You want HTML tags as objects?

> You want surefire generated HTML tags and HTML attributes?

> You want to generate HTML tags on the fly?

> This module comes to the rescue!

[![Build Status](https://travis-ci.org/sandrokeil/HtmlElement.png?branch=master)](https://travis-ci.org/sandrokeil/HtmlElement)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sandrokeil/HtmlElement/badges/quality-score.png?s=17ebfee6d9890d3f43becccc084746fed2fc6707)](https://scrutinizer-ci.com/g/sandrokeil/HtmlElement/)
[![Coverage Status](https://coveralls.io/repos/sandrokeil/HtmlElement/badge.png)](https://coveralls.io/r/sandrokeil/HtmlElement)
[![HHVM Status](http://hhvm.h4cc.de/badge/sandrokeil/html-element.svg)](http://hhvm.h4cc.de/package/sandrokeil/html-element)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/be3b8aac-da7b-4ae1-a842-82ffca2712d0/mini.png)](https://insight.sensiolabs.com/projects/be3b8aac-da7b-4ae1-a842-82ffca2712d0)
[![Latest Stable Version](https://poser.pugx.org/sandrokeil/html-element/v/stable.png)](https://packagist.org/packages/sandrokeil/html-element)
[![Dependency Status](https://www.versioneye.com/user/projects/53615cc9fe0d07fa670000cb/badge.png)](https://www.versioneye.com/user/projects/53615cc9fe0d07fa670000cb)
[![Total Downloads](https://poser.pugx.org/sandrokeil/html-element/downloads.png)](https://packagist.org/packages/sandrokeil/html-element)
[![License](https://poser.pugx.org/sandrokeil/html-element/license.png)](https://packagist.org/packages/sandrokeil/html-element)

Zend Framework view helper plugin for generating HTML tags. Use HTML tags as objects and manipulate HTML attributes and values.

 * **Well tested.** Besides unit tests and continuous integration/inspection this solution is also ready for production use.
 * **Great foundations.** Based on [Zend Framework](https://github.com/zendframework) and [interop-config](https://github.com/sandrokeil/interop-config)
 * **Every change is tracked**. Want to know whats new? Take a look at [CHANGELOG.md](CHANGELOG.md)
 * **Listen to your ideas.** Have a great idea? Bring your tested pull request or open a new issue. See [CONTRIBUTING.md](CONTRIBUTING.md)

## Installation

Installation of this module uses Composer. For Composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

Put the following into your composer.json

    {
        "require": {
            "sandrokeil/html-element": "^2.0"
        }
    }

Please register the `HtmlElement` view helper to your [Zend\View plugin manager](https://zendframework.github.io/zend-view/helpers/advanced-usage/). 
You can use the `Sake\HtmlElement\Service\HtmlElementFactory` factory if you install [interop-config](https://github.com/sandrokeil/interop-config).

```php
return [
   'view_helpers' => [
        'factories' => [
            \Sake\HtmlElement\View\Helper\HtmlElement::class => \Sake\HtmlElement\Service\HtmlElementFactory::class,
        ],
    ],
];
```

## Documentation

The usage is easy. Here is an example how to use the view helper

```php
<?php

// assume we are in a template
echo $this->html('div', 'my content', array('id' => 'content', 'class' => 'box shadow'));

// or
$div = $this->html('div');
echo $div->setText('my content')
    ->setAttributes(array('id' => 'content', 'class' => 'box shadow'));

// to render HTML you can use
echo $div->enableHtml(true)
    ->setText(
        $this->html('p')->setText('Hello World!')->appendClass('welcome');
    );

// or
echo $this->html(
    'div',
    $this->html('p')->setText('Hello World!')->appendClass('welcome'),
    array('id' => 'content', 'class' => 'box shadow'),
    true
);
```

## Performance tweaks
The default behaviour of HtmlElement is maximum security. But if you have thousands of HTML tags it could be slow.
If your HTML attributes are not from user input, you can disable escaping of HTML attributes to increase performance.
You can also disable escaping of text to unleash the beast. ;-) This is simply done by adding the following lines to
your config file, but keep security in mind.

```php
<?php

return array(
    'sake_htmlelement' => array(
        'view_helper' => array(
            'default' => array(
                'escapeHtmlAttribute' => false,
                'escapeText' => false,
            ),
        ),
    ),
    // other module config stuff
);

```
