<?php

namespace Crawler\Facades;

use Crawler\Selectors\DomDocumentSelector;
use Crawler\Selectors\CssSelector;
use Crawler\Core\Spider;
use Crawler\Contracts\SelectInterface;

class CrawlFacade
{

    public $urls;
    public $selector = 'xpath';
    public $defaultSelect = null;
    public $sleep = 0;
    public $exportType = 'DOMElement';

    public function __construct($urls)
    {
        $this->urls = $urls;
    }

    public function start()
    {
        $spider = new Spider($this->urls, $this->sleep);
        $dependencySelectorClass = $this->setSelectorClass($this->selector, $this->defaultSelect, $this->exportType);
        return $spider->search($dependencySelectorClass);
    }

    // manage dependency
    public function setSelectorClass($selectorClassName, $defaultSelect, $exportType): SelectInterface
    {
        switch ($selectorClassName) {
            case 'xpath' :
                return new DomDocumentSelector($defaultSelect, $exportType);
                break;
            case 'css' :
                return new CssSelector($defaultSelect, $exportType);
                break;
            default :
                return new DomDocumentSelector($defaultSelect, $exportType);
        }
    }

    public function selector($selector)
    {
        $this->selector = $selector;
        return $this;
    }

    public function defaultSelect($defaultSelect)
    {
        $this->defaultSelect = $defaultSelect;
        return $this;
    }

    public function sleep($sleep)
    {
        $this->sleep = $sleep;
        return $this;
    }

    public static function make($urls)
    {
        return new self($urls);
    }

}