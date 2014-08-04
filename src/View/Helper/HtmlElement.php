<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/HtmlElement for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/HtmlElement/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\HtmlElement\View\Helper;

use Zend\Escaper\Escaper;
use Zend\View\Helper\AbstractHelper;

/**
 * HtmlElement view helper
 *
 * This view helper creates a html tag object which can be configured and rendered.
 */
class HtmlElement extends AbstractHelper
{
    /**
     * Tag type e.g. div
     *
     * @var string
     */
    protected $tag;

    /**
     * Tag content
     *
     * @var string
     */
    protected $text = '';

    /**
     * Array of attribute / value pair
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * Escape html
     *
     * @var bool
     */
    protected $renderHtml = false;

    /**
     * List of self closing tags for valid html
     *
     * @var array
     */
    protected $singletonTags = array(
        'area',
        'base',
        'br',
        'col',
        'command',
        'embed',
        'hr',
        'img',
        'input',
        'keygen',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
    );

    /**
     * Html attribute escaper
     *
     * @var Escaper
     */
    protected $helperEscapeHtmlAttr;

    /**
     * Html escaper
     *
     * @var Escaper
     */
    protected $helperEscapeHtml;

    /**
     * Create html object with provided settings.
     *
     * @param string $tag Html tag
     * @param string $text Html content
     * @param array $attributes Html attributes
     * @param bool $renderHtml Escape html
     * @return HtmlElement
     */
    public function __invoke($tag, $text = '', array $attributes = array(), $renderHtml = false)
    {
        $html = clone $this;

        $html->setTag($tag);
        $html->setText($text);
        $html->setAttributes($attributes);
        $html->enableHtml($renderHtml);
        return $html;
    }

    /**
     * Renders element. Triggers an error instead of throw an exception, because it is not allowed here.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            $html = $this->render();
        } catch (\Exception $exception) {
            trigger_error($exception->getMessage() . PHP_EOL . $exception->getTraceAsString(), E_USER_WARNING);
            $html = '';
        }
        return $html;
    }

    /**
     * Alias for __toString
     *
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }

    /**
     * Returns tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Returns the current text (content) of tag
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Returns an array of html attribute / value pair for the current html element
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets an array of html attributes / value pair
     *
     * @param array $attributes Html attributes
     * @return HtmlElement
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Sets html tag
     *
     * @param string $tag
     * @return HtmlElement
     */
    public function setTag($tag)
    {
        $this->tag = (string) $tag;
        return $this;
    }

    /**
     * Sets tag text (content)
     *
     * @param string $text
     * @return HtmlElement
     */
    public function setText($text)
    {
        $this->text = (string) $text;
        return $this;
    }

    /**
     * Appends text
     *
     * @param string $text
     * @return HtmlElement
     */
    public function appendText($text)
    {
        $this->text .= (string) $text;
        return $this;
    }

    /**
     * Returns css classes
     *
     * @return string
     */
    public function getClass()
    {
        return isset($this->attributes['class']) ? $this->attributes['class'] : '';
    }

    /**
     * Sets a css class for current element. This method overrides all existing css classes. To append css classes
     * use appendClass()
     *
     * @param string $class Css class
     * @return HtmlElement
     */
    public function setClass($class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    /**
     * Appends a css class to current element.
     *
     * @param string $class Css class
     * @return HtmlElement
     */
    public function appendClass($class)
    {
        if (!isset($this->attributes['class'])) {
            $this->attributes['class'] = '';
        } else {
            $this->attributes['class'] .= ' ';
        }
        $this->attributes['class'] .= (string) $class;
        return $this;
    }

    /**
     * Returns id attribute of current element
     *
     * @return string
     */
    public function getId()
    {
        return isset($this->attributes['id']) ? $this->attributes['id'] : '';
    }

    /**
     * Sets id attribute for current element
     *
     * @param string $id Name
     * @return HtmlElement
     */
    public function setId($id)
    {
        $this->attributes['id'] = (string) $id;
        return $this;
    }

    /**
     * Return true or false to indicate escaping of text
     *
     * @return bool
     */
    public function useHtml()
    {
        return $this->renderHtml;
    }

    /**
     * Turn on / off html rendering text
     *
     * @param bool $renderHtml Render html or escape content
     * @return HtmlElement
     */
    public function enableHtml($renderHtml)
    {
        $this->renderHtml = (bool) $renderHtml;
        return $this;
    }

    /**
     * Builds html attributes
     *
     * @return string
     */
    protected function buildAttributes()
    {
        $attributes = '';

        foreach ($this->attributes as $key => $value) {
            $attributes .= ' ' . $key . '="' . $this->getHelperEscapeHtmlAttr()->escapeHtmlAttr($value) . '"';
        }
        return $attributes;
    }

    /**
     * Renders html element
     *
     * @return string
     */
    public function render()
    {
        if (in_array($this->tag, $this->singletonTags)) {
            // strict html 5 is omitted for backward compatibility, html 5 is still valid
            return '<' . $this->tag . $this->buildAttributes() . ' />';
        }

        if (!$this->renderHtml) {
            $text = $this->getHelperEscapeHtml()->escapeHtml($this->text);
        } else {
            $text = $this->text;
        }
        return '<' . $this->tag . $this->buildAttributes() . '>' . $text . '</' . $this->tag . '>';
    }

    /**
     * Sets escaper for html
     *
     * @param Escaper $helperEscapeHtml
     * @return HtmlElement
     */
    public function setHelperEscapeHtml(Escaper $helperEscapeHtml)
    {
        $this->helperEscapeHtml = $helperEscapeHtml;
        return $this;
    }

    /**
     * Sets escaper for html attributes
     *
     * @param Escaper $helperEscapeHtmlAttr
     * @return HtmlElement
     */
    public function setHelperEscapeHtmlAttr(Escaper $helperEscapeHtmlAttr)
    {
        $this->helperEscapeHtmlAttr = $helperEscapeHtmlAttr;
        return $this;
    }

    /**
     * Returns escaper for html attrbiutes, if no one is set, escaper of view will be used
     *
     * @return Escaper
     */
    protected function getHelperEscapeHtmlAttr()
    {
        if (null === $this->helperEscapeHtmlAttr) {
            $this->helperEscapeHtmlAttr = $this->getView()->plugin('escapehtmlattr')->getEscaper();
        }
        return $this->helperEscapeHtmlAttr;
    }

    /**
     * Returns escaper for html, if no one is set, escaper of view will be used
     *
     * @return Escaper
     */
    protected function getHelperEscapeHtml()
    {
        if (null === $this->helperEscapeHtml) {
            $this->helperEscapeHtml = $this->getView()->plugin('escapehtml')->getEscaper();
        }
        return $this->helperEscapeHtml;
    }
}
