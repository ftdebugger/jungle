<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:04
 */

namespace Jungle\Token;


class Token
{

    const T_WHITESPACE = 0;
    const T_KEYWORD = 1;
    const T_BLOCK_OPEN = 2;
    const T_BLOCK_CLOSE = 3;

    const T_STRING = 4;
    const T_STRING_ESCAPED = 5;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var int
     */
    protected $type;

    /**
     * @param string $value
     * @param int $type
     */
    public function __construct($value, $type)
    {
        $this->type = $type;
        $this->value = $value;
    }


    /**
     * Set value of Type
     *
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Return value of Type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set value of Value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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

