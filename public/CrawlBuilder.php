<?php


class CrawlBuilder
{
    public $url;
    public $selector = 'xpath';
    public $defaultSelect = null;
    public $sleep = 0;
    public $exportType = 'DomObject';

    public function __construct($url)
    {
        $this->url = $url;
        return $this;
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

    public function exportType($exportType)
    {
        $this->exportType = $exportType;
        return $this;
    }

    public function build(): Spider
    {
        $spider = new Spider();
        return $spider->setPropertiesWithBuilder($this);
    }

}
