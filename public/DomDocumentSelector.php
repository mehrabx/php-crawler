<?php

include_once 'SelectInterface.php';

class DomDocumentSelector implements SelectInterface
{
    public static $dom;
    public static $domx;
    public $defaultSelect;
    public $exportType;
    public $result = [];

    public function __construct($defaultSelect, $exportType)
    {
        $this->defaultSelect = $defaultSelect;
        $this->exportType = $exportType;
    }

    public static function setDOMDocument(): DOMDocument
    {
        if (!self::$dom)
            self::$dom = new DOMDocument();
        return self::$dom;
    }

    public static function setDOMXPath($dom): DOMXPath
    {
//        if (!self::$domx)
//            self::$domx = new \DOMXPath($dom);
//        return self::$domx;
        return self::$domx = new \DOMXPath($dom);
    }

    public function filter($content, $selectors)
    {

        $dom = $this->initialDOMDocument($content);

        $domx = self::setDOMXPath($dom);

        $this->result = [];

        if (!is_array($selectors) || !$selectors) {
            $this->generateData($domx, $this->defaultSelect);
        } else {
            foreach ($selectors as $item) {
                $this->generateData($domx, $item);
            }
        }

        return $this->result;
    }

    public static function getAttribute($element, $attrName)
    {
        foreach ($element->attributes as $node) {
            if ($node->name == $attrName) {
                return $node->value;
            }
        }
    }

    public function initialDOMDocument($content): DOMDocument
    {
        $dom = self::setDOMDocument();
//        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        libxml_use_internal_errors(false);

        return $dom;
    }

    private function generateData($domx, $select)
    {
        var_dump($select);
        $elements = $domx->query($select);
        if (!is_null($elements)) {
            foreach ($elements as $element) {
                $this->result[$this->defaultSelect][] =  $this->getAttribute($element,'src');
//                $this->result[$this->defaultSelect][] = "<img src='{$this->getAttribute($element,'src')}' height='150' width='150'>";
            }
        }
    }


}