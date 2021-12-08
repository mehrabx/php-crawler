<?php


use Crawler\Selectors\DomDocumentSelector;
use PHPUnit\Framework\TestCase;

final class DomDocumentSelectorTest extends TestCase
{
    protected $selectArray;
    protected $selectString;
    protected $domSelector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->selectArray = ["//img[@class='course_image']"];
        $this->selectString = "//img[@class='course_image']";
        $this->domSelector = new DomDocumentSelector();
    }

    public function test_filter_method_when_select_is_array()
    {
        list($domSelector, $res) = $this->call_filter_method($this->selectArray);

        $this->assertCount(1, $res);
        $this->assertCount(3, $res[$this->selectArray[0]]);
        $this->assertInstanceOf(DOMElement::class,$res[$this->selectArray[0]][rand(0, 2)] );

    }

    public function test_filter_method_when_select_is_string()
    {
        list($domSelector, $res) = $this->call_filter_method($this->selectString);

        $this->assertCount(1, $res);
        $this->assertCount(3, $res[$this->selectString]);
        $this->assertInstanceOf(DOMElement::class,$res[$this->selectString][rand(0, 2)] );
    }

    public function test_filter_method_when_select_is_not_set_and_use_default_select()
    {
        list($domSelector, $res) = $this->call_filter_method(null, $setDefault = true);

        $res = $domSelector->result;

        $this->assertCount(1, $res);
        $this->assertCount(3, $res[$domSelector->defaultSelect]);
        $this->assertInstanceOf(DOMElement::class,$res[$domSelector->defaultSelect][rand(0, 2)]);

    }

    public function test_filter_method_when_select_and_default_select_is_not_set()
    {
        list($domSelector, $res) = $this->call_filter_method(null, $setDefault = false);

        $this->assertCount(1, $res);
        $this->assertCount(1, $res[$domSelector->defaultSelect]);
        $this->assertEmpty($res[$domSelector->defaultSelect][0]);
    }

    /**
     * @param $select
     * @return array
     */
    public function call_filter_method($select, $setDefault = false)
    {
        $domSelector = $this->domSelector;

        $setDefault ? $domSelector->defaultSelect = $this->selectString : null;

        $res = $domSelector->filter(file_get_contents(__DIR__ . '/ContentTest.html'), $select);

        return array($domSelector, $domSelector->result);
    }

    public function test_initialDOMDocument_method()
    {
        $res = $this->domSelector->initialDOMDocument(file_get_contents(__DIR__.'/ContentTest.html'));
        $this->assertInstanceOf(DOMDocument::class ,$res );


        return $res;
    }

    /**
     * @depends test_initialDOMDocument_method
     */
    public function test_setDOMXPath_method($dom)
    {

        $res = $this->domSelector->setDOMXPath($dom);
        $this->assertInstanceOf(DOMXPath::class ,$res );

    }


    /**
     * @depends test_setDOMXPath_method
     */
    public function test_generateData_method()
    {
        //other conditions checked in filter_method tests

        $select = $this->selectString;
        $domSelector = $this->domSelector;

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(file_get_contents(__DIR__ . '/ContentTest.html'));
        libxml_use_internal_errors(false);

        $domx = new DOMXPath($dom);

        $domSelector->generateData($domx, $select);

        $this->assertTrue(isset($domSelector->result[$select]));
        $this->assertInstanceOf(DOMElement::class,$domSelector->result[$select][0]);

    }


}