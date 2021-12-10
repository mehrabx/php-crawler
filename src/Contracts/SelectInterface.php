<?php

namespace Mehrabx\Crawler\Contracts;

interface SelectInterface
{
    public function filter($content,$selects)  ;
}