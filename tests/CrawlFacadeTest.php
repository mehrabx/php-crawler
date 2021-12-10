<?php

namespace Mehrabx\Crawler\Tests;

use Mehrabx\Crawler\Contracts\SelectInterface;
use Mehrabx\Crawler\Facades\CrawlFacade;
use Mehrabx\Crawler\Selectors\CssSelector;
use Mehrabx\Crawler\Selectors\DomDocumentSelector;
use PHPUnit\Framework\TestCase;

class CrawlFacadeTest extends TestCase
{
    protected $urls;
    public $crawFacade;

    public function setUp(): void
    {
        $this->crawFacade = new CrawlFacade($this->urls);
        $this->urls = [
            'https://google.com' => ["//img[@class='course_image']"],
            'https://test.ir' => ["//a[@class='test_a']"]
        ];
    }

    public function test_setSelectorClass_method_when_selector_is_xpath()
    {
        $res = $this->call_setSelectedClass_method('xpath');
        $this->assertInstanceOf( DomDocumentSelector::class,$res);
    }

    public function test_setSelectorClass_method_when_selector_is_css()
    {
        $res = $this->call_setSelectedClass_method('css');
        $this->assertInstanceOf( CssSelector::class, $res);

    }

    public function test_setSelectorClass_method_when_selector_is_not_expected()
    {
        $res = $this->call_setSelectedClass_method('other');
        $this->assertInstanceOf( DomDocumentSelector::class, $res);

    }

    public function call_setSelectedClass_method($selector): SelectInterface
    {
        $crawlFacade = $this->crawFacade;
        return $crawlFacade->setSelectorClass($selector, null, 'DOMElement');
    }

    public function test_selector_method()
    {
        $this->crawFacade->selector('xpath');
        $this->assertEquals('xpath', $this->crawFacade->selector);
    }

    public function test_defaultSelect_method()
    {
        $this->crawFacade->defaultSelect("[//img[@class='test']]");
        $this->assertEquals("[//img[@class='test']]", $this->crawFacade->defaultSelect);
    }

    public function test_sleep_method()
    {
        $this->crawFacade->sleep(3);
        $this->assertEquals(3, $this->crawFacade->sleep);
    }

    public function test_work_method()
    {
        $res = CrawlFacade::make($this->urls);
        $this->assertInstanceOf( CrawlFacade::class, $res);
    }

}