<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/31/13 18:09
 */

namespace Jungle\Example\CSS;


class Rule
{

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Return value of Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Return value of Value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

}