<?php

include_once 'DomDocumentSelector.php';
include_once 'CrawlBuilder.php';
include_once 'CrawlFacade.php';
include_once 'Spider.php';

//$urls = [
//    'https://www.mongard.ir/courses/?page=2' => ["//img[@class='course_image']"],
//    'https://www.mongard.ir/courses/?page=3' => ["//img[@class='course_image']"],
////    'https://www.mongard.ir/courses/?page=4' => ["//img[@class='course_image']"],
//];

$urls = [
    'https://footballi.net' => ["//img[@class='player-pic']","//img[@class='object-fit-cover']"],
];

return (new CrawlFacade())->work($urls);


//$selector = "//img[@class='course_image']";

//$spider = (new CrawlBuilder($urls))
//    ->sleep(10)
//    ->exportType('xpath')
//    ->exportType('DomObject')
//    ->build();


