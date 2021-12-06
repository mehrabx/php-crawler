<?php


use Crawler\Core\Spider;
use PHPUnit\Framework\TestCase;

class SpiderTest extends TestCase
{
    protected $urls = [
        'https://google.com' => ["//img[@class='course_image']"],
        'https://test.ir' => ["//a[@class='test_a']"]
    ];
    protected $spider;
    protected $content;
    protected $selectArray;
    protected $selectString;

    public function setUp(): void
    {
        parent::setUp();
        $this->spider = new Spider($this->urls);
        $this->content = file_get_contents(__DIR__.'/ContentTest.html');
        $this->selectArray = ["//img[@class='course_image']"];
        $this->selectString = "//img[@class='course_image']";
    }
//
    public function test_sleep_method_with_argument_not_equal_0()
    {
        $sleep = 1;
        $spider = new Spider($this->urls, $sleep);

        $this->assertEquals($spider->getSleep(), sleep(1));
    }

    public function test_sleep_method_with_argument_equal_0()
    {
        $sleep = 0;
        $spider = new Spider($this->urls, $sleep);

        $this->assertEquals(null, $spider->getSleep());
    }

    public function test_search_method()
    {
        //mocking selector
        $selector = Mockery::mock(\Crawler\Selectors\SelectInterface::class);
        $selector->shouldReceive('filter')
            ->times(2)
            ->with(Mockery::any(),Mockery::any())
            ->andReturn([$this->selectString => [DOMElement::class]]);


       $res = $this->spider->search($selector);

       $this->assertTrue(isset($this->spider->result['https://google.com']));
       $this->assertTrue(is_array($this->spider->result['https://google.com']));
       $this->assertTrue(in_array($this->selectString,array_keys($this->spider->result['https://google.com'])));
       $this->assertTrue(isset($this->spider->result['https://test.ir']));
       $this->assertTrue(is_array($this->spider->result['https://test.ir']));
        $this->assertTrue(in_array($this->selectString,array_keys($this->spider->result['https://test.ir'])));
    }

}