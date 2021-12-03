<?php

namespace Crawler\Selectors;

use Crawler\Selectors\SelectInterface;

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

    public static function setDOMDocument(): \DOMDocument
    {
        if (!self::$dom)
            self::$dom = new \DOMDocument();
        return self::$dom;
    }

    public static function setDOMXPath($dom): \DOMXPath
    {
        return self::$domx = new \DOMXPath($dom);
    }

    public function filter($content, $selects)
    {

        $dom = $this->initialDOMDocument($content);

        $domx = self::setDOMXPath($dom);

        $this->result = [];

        if (!is_array($selects) || !$selects) {
            $this->generateData($domx, $this->defaultSelect);
        } else {
            foreach ($selects as $item) {
                $this->generateData($domx, $item);
            }
        }

        return $this->result;
    }


    public function initialDOMDocument($content): \DOMDocument
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
        $elements = $domx->query($select);
        if (!is_null($elements)) {
            foreach ($elements as $element) {
                $this->result[$select][] = $element;
//                $this->result[$select] = $this->defineExportType($element);
//                $this->result[$select] = $this->getAttribute($element, 'src');
//                $this->result[$select] = "<img src='{$this->getAttribute($element,'src')}' height='150' width='150'>";
            }
        }
    }

    private function defineExportType($element)
    {
        if (is_array($this->exportType)) {
            $data = [];
            foreach ($this->exportType as $type => $value) {
                switch ($type) {
                    case 'attr' :
                        $data['attr'][] = $this->getAttribute($element, $value);
//                    case 'value' : $data[''][] =
                }
            }
            return $data;
        }

        return $element;
    }

    public static function getAttribute($element, $attrName)
    {
        foreach ($element->attributes as $node) {
            if ($node->name == $attrName) {
                return $node->value;
            }
        }
    }


}