<?php

include_once 'index.php';
include_once 'DomDocumentSelector.php';

class CrawlFacade
{

    public function work($url, $defaultSelect = null, $selector = 'xpath', $sleep = 0, $exportType = 'DomObject')
    {
        $spider = new Spider($url, $sleep);
        $dependencySelectorClass = $this->setSelectorClass($selector, $defaultSelect, $exportType);
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
                return new CssSelector($exportType, $exportType);
                break;
            default :
                return new DomDocumentSelector($defaultSelect, $exportType);
        }
    }

}