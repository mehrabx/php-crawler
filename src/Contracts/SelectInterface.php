<?php

namespace Crawler\Contracts;

interface SelectInterface
{
    public function filter($content,$selects)  ;
}