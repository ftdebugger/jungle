<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/30/13 19:42
 */

namespace Jungle\Lexer;


abstract class AbstractLexer implements LexerInterface
{

    /**
     * @var int
     */
    protected $weight = 0;

    /**
     * Set value of Weight
     *
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * Return value of Weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }


}