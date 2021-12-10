<p align="center"><img src="resources/imgs/logo.png?raw=true"></p>

# PHP Web Crawler

This library is a php web crawler which takes collection of URLs and DOM selects to crawl through the webpages and
executing customized analyzers on each page.

## Installation

Install this library using composer :

```sh
composer require mehrabx/web-crawler
```

## Usage
In current version use [xpath expressions](https://www.w3schools.com/xml/xpath_intro.asp) to select element

```php

//set list of URLs and selects DOM elements of each URL page
$urls = [
    'https://test.exp/?page=1' => ["//img[@class='type1']","//a[@class='type1']"],
    'https://test.exp/?page=2' => ["//img[@class='type2'"],
    'https://test.exp/?page=3' => "//img[@class='type3']",
];

//return array of results
return \Crawler\Facades\CrawlFacade::make($urls)->start() ;

```

## options

### sleep

To avoid being blocked by the target url you can set sleep time between crawling each url :

```php

$urls = [
    'https://test.exp/?page=1' => ["//img[@class='type1']","//a[@class='type1']"],
    'https://test.exp/?page=2' => ["//img[@class='type2'"],
];

//set 5 seconds sleep time 
return \Crawler\Facades\CrawlFacade::make($urls)->sleep(10)->start() ;
```


### defualt select

You can set default select. URLs that have no selects can use it  :

```php

$urls = [
    'https://test.exp/?page=1', //this url has not select
    'https://test.exp/?page=2' => ["//img[@class='type2'"],
];

return \Crawler\Facades\CrawlFacade::make($urls)
                                    ->defaultSelect("//img[@class='type1']")
                                    ->start() ;
```
