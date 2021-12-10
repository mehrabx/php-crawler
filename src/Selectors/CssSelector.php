<?php

namespace Mehrabx\Crawler\Selectors;

use Mehrabx\Crawler\Contracts\SelectInterface;

class CssSelector implements SelectInterface
{

    public function __construct($defaultSelect, $exportType)
    {

    }

    public function filter($content, $selects)
    {
        // TODO: Implement filter() method.
    }
}