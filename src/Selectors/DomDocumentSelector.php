<?php

namespace Mehrabx\Crawler\Selectors;

use DOMDocument;
use Mehrabx\Crawler\Contracts\SelectInterface;

class DomDocumentSelector implements SelectInterface
{
    public static $dom;
    public $domx;
    public $defaultSelect;
    public $exportType;
    public $result = [];

    public function __construct($defaultSelect = null, $exportType = null)
    {
        $this->defaultSelect = $defaultSelect;
        $this->exportType = $exportType;
    }


    public function filter($content, $selects)
    {

        $dom = $this->initialDOMDocument($content);
        $domx = $this->setDOMXPath($dom);

        $this->result = [];

        if (!is_array($selects) || !$selects) {
            $this->generateData($domx, $selects ?? $this->defaultSelect);
        } else {
            foreach ($selects as $item) {
                $this->generateData($domx, $item);
            }
        }

        return $this->result;
    }


    public function generateData($domx, $select)
    {
        if (!$select) return $this->result[$select][] = null;

        $elements = $domx->query($select);
        if (!is_null($elements)) {
            foreach ($elements as $element) {
                $this->result[$select][] = $element;
            }
        }

    }

    public function setDOMXPath($dom): \DOMXPath
    {
        $this->domx = new \DOMXPath($dom);
        return $this->domx;
    }

    public function initialDOMDocument($content): DOMDocument
    {
        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        libxml_use_internal_errors(false);

        return $dom;
    }


//                $this->result[$select] = $this->defineExportType($element);
//                $this->result[$select] = $this->getAttribute($element, 'src');

//    private function defineExportType($element)
//    {
//        if (is_array($this->exportType)) {
//            $data = [];
//            foreach ($this->exportType as $type => $value) {
//                switch ($type) {
//                    case 'attr' :
//                        $data['attr'][] = $this->getAttribute($element, $value);
////                    case 'value' : $data[''][] =
//                }
//            }
//            return $data;
//        }
//
//        return $element;
//    }
//
//    public static function getAttribute($element, $attrName)
//    {
//        foreach ($element->attributes as $node) {
//            if ($node->name == $attrName) {
//                return $node->value;
//            }
//        }
//    }
//

}