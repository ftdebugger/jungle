<?php

namespace Jungle\Example\CSS;


class Selector
{

    /**
     * @var array
     */
    protected $selectors = array();

    /**
     * @param string $selector
     */
    public function __construct($selector)
    {
        $this->selectors[] = $selector;
    }

    /**
     * @param string $selector
     */
    public function addSelector($selector)
    {
        $this->selectors[] = $selector;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return implode("", $this->selectors);
    }

}