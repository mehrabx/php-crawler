<?php

namespace Crawler\Selectors;

use Crawler\Selectors\SelectInterface;

class CssSelector implements SelectInterface
{

    public function __construct($exportType)
    {

    }

    public function filter($content, $selector)
    {
        // TODO: Implement filter() method.
    }
}