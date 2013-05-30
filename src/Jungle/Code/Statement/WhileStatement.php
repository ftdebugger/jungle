<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 14:27
 */

namespace Jungle\Code\Statement;


use Jungle\Code\AbstractGenerator;

class WhileStatement extends AbstractGenerator
{

    /**
     * @var string
     */
    protected $condition;

    /**
     * @var string
     */
    protected $body;

    /**
     * @param string $condition
     * @param string $body
     */
    public function __construct($condition = null, $body = null)
    {
        $this->body = $body;
        $this->condition = $condition;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $code = 'while (' . $this->getCondition() . ') {' . PHP_EOL;
        $code .= $this->indentBlock($this->getBody()) . PHP_EOL;
        $code .= '}';

        return $code;
    }


    /**
     * Set value of Body
     *
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Return value of Body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set value of Condition
     *
     * @param string $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * Return value of Condition
     *
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

}