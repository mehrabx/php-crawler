<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Crawler\Facades\CrawlFacade;

$urls = [
    'https://www.mongard.ir/courses/?page=2' => ["//img[@class='course_image']","//a[@class='course_link']"],
    'https://www.mongard.ir/courses/?page=3' => ["//img[@class='course_image']"],
//    'https://www.mongard.ir/courses/?page=4' => ["//img[@class='course_image']"],
];

//$urls = [
//    'https://footballi.net' => ["//img[@class='player-pic']"],
//];

return CrawlFacade::make($urls)->start() ;



