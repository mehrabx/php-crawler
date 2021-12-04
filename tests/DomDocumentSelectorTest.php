<?php


use Crawler\Selectors\DomDocumentSelector;
use PHPUnit\Framework\TestCase;

final class DomDocumentSelectorTest extends TestCase
{


    public function test_filter_method_when_select_is_array()
    {

        $select = ["//img[@class='course_image']"];

        list($domSelector, $res) = $this->call_filter_method($select);

        $res = ($domSelector->result);

        $this->assertCount(1, $res);
        $this->assertCount(3, $res[$select[0]]);
        $this->assertTrue($res[$select[0]][0] instanceof DOMElement);
    }


    public function test_filter_method_when_select_is_string()
    {

        $select = "//img[@class='course_image']";

        list($domSelector, $res) = $this->call_filter_method($select);

        $res = ($domSelector->result);

        $this->assertCount(1, $res);
        $this->assertCount(3, $res[$select]);
        $this->assertTrue($res[$select][0] instanceof DOMElement);

        return  ;
    }

    public function test_filter_method_when_select_is_not_set_and_use_default_select()
    {

        list($domSelector, $res) = $this->call_filter_method(null, $setDefault = true);

        $res = ($domSelector->result);

        $this->assertCount(1, $res);
        $this->assertCount(3, $res[$domSelector->defaultSelect]);
        $this->assertTrue($res[$domSelector->defaultSelect][0] instanceof DOMElement);
    }

    /**
     * @param $select
     * @return array
     */
    public function call_filter_method($select, $setDefault = false)
    {
        $domSelector = new DomDocumentSelector('', '');

        $setDefault ? $domSelector->defaultSelect = "//img[@class='course_image']" : null;

        $res = $domSelector->filter(file_get_contents(__DIR__ . '/ContentTest.html'), $select);

        return array($domSelector, $res);
    }

    public function test_setDOMDocument_method()
    {

        $res1 = DomDocumentSelector::setDOMDocument();
        $res2 = DomDocumentSelector::setDOMDocument();
        $class3 = new DOMDocument();

        $this->assertTrue($res1 && $res2 instanceof DOMDocument);
        $this->assertTrue($res1 === $res2);
        $this->assertTrue($res1 && $res2 !== $class3);

        return $res1;
    }

    /**
     * @depends test_setDOMDocument_method
     */
    public function test_setDOMXPath_method($dom)
    {
        $res = DomDocumentSelector::setDOMXPath($dom);
        $this->assertTrue($res instanceof DOMXPath);

        return $res;
    }

//    /**
//     * @depends test_setDOMXPath_method
//     */
//    public function test_generateData_method($res){
//
//        $select = "//img[@class='course_image']";
//        $domSelector = new DomDocumentSelector('', '');
//
//        $res = $domSelector->generateData($res,$select);
//
//        $this->assertTrue(isset($domSelector->result[$select]));
//        $this->assertTrue($domSelector->result[$select][0] instanceof DOMElement);
//
//    }


}