<?php

namespace Crawler\Selectors;

interface SelectInterface
{
    public function filter($content,$selects)  ;
}