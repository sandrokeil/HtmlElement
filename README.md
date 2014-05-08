# HtmlElement view helper for Zend Framework 2

[![Build Status](https://travis-ci.org/sandrokeil/HtmlElement.png?branch=master)](https://travis-ci.org/sandrokeil/HtmlElement)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sandrokeil/HtmlElement/badges/quality-score.png?s=17ebfee6d9890d3f43becccc084746fed2fc6707)](https://scrutinizer-ci.com/g/sandrokeil/HtmlElement/)
[![Coverage Status](https://coveralls.io/repos/sandrokeil/HtmlElement/badge.png)](https://coveralls.io/r/sandrokeil/HtmlElement)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f105b7da-8af5-42c8-995e-9eb842070746/mini.png)](https://insight.sensiolabs.com/projects/f105b7da-8af5-42c8-995e-9eb842070746)
[![Latest Stable Version](https://poser.pugx.org/sandrokeil/html-element/v/stable.png)](https://packagist.org/packages/sandrokeil/html-element)
[![Dependency Status](https://www.versioneye.com/user/projects/53615cc9fe0d07fa670000cb/badge.png)](https://www.versioneye.com/user/projects/53615cc9fe0d07fa670000cb)
[![Total Downloads](https://poser.pugx.org/sandrokeil/html-element/downloads.png)](https://packagist.org/packages/sandrokeil/html-element)
[![License](https://poser.pugx.org/sandrokeil/html-element/license.png)](https://packagist.org/packages/sandrokeil/html-element)

Zend Framework 2 view helper plugin for generating html element. Use html tags as objects and manipulate html attributes and values.

 * **Well tested.** Besides unit test and continuous integration/inspection this solution is also ready for production use.
 * **Great foundations.** Based on [Zend Framework 2](https://github.com/zendframework/zf2)
 * **Every change is tracked**. Want to know whats new? Take a look at [CHANGELOG.md](https://github.com/sandrokeil/HtmlElement/blob/master/CHANGELOG.md)
 * **Listen to your ideas.** Have a great idea? Bring your tested pull request or open a new issue.

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

Put the following into your composer.json

    {
        "require": {
            "sandrokeil/html-element": "dev-master"
        }
    }

Then add `Sake\HtmlElement` to your `./config/application.config.php`.

## Documentation

The usage is easy. Here is an example how to use the view helper

```php
<?php

// assume we are in a template
echo $this->html('div', 'my content', array('id' => 'content', 'class' => 'box shadow'));

// or
$div = $this->html('div');
$div->setText('my content')
    ->setAttributes(array('id' => 'content', 'class' => 'box shadow'));

// to render html you can use
$div->enableHtml(true)
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
