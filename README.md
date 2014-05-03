# HtmlElement view helper for Zend Framework 2

[![Build Status](https://travis-ci.org/sandrokeil/HtmlElement.png?branch=master)](https://travis-ci.org/sandrokeil/HtmlElement)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sandrokeil/HtmlElement/badges/quality-score.png?s=17ebfee6d9890d3f43becccc084746fed2fc6707)](https://scrutinizer-ci.com/g/sandrokeil/HtmlElement/)
[![Coverage Status](https://coveralls.io/repos/sandrokeil/HtmlElement/badge.png)](https://coveralls.io/r/sandrokeil/HtmlElement)
[![Latest Stable Version](https://poser.pugx.org/sandrokeil/html-element/v/stable.png)](https://packagist.org/packages/sandrokeil/html-element)
[![Dependency Status](https://www.versioneye.com/user/projects/53615cc9fe0d07fa670000cb/badge.png)](https://www.versioneye.com/user/projects/53615cc9fe0d07fa670000cb)
[![Total Downloads](https://poser.pugx.org/sandrokeil/html-element/downloads.png)](https://packagist.org/packages/sandrokeil/html-element)
[![License](https://poser.pugx.org/sandrokeil/html-element/license.png)](https://packagist.org/packages/sandrokeil/html-element)

Zend Framework 2 view helper plugin for generating html element. Use html tags as objects and manipulate html
attributes and values.

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
```
