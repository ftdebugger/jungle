<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 13:49
 */

namespace Jungle\Code;


abstract class AbstractGenerator implements GeneratorInterface
{

    /**
     * @var string
     */
    protected $indent = '    ';

    /**
     * @param string $string
     *
     * @return string
     */
    protected function indentBlock($string)
    {
        return preg_replace('#^(.+?)$#m', $this->indent . '$1', trim($string));
    }

    /**
     * Set value of Indent
     *
     * @param string $indent
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;
    }

    /**
     * Return value of Indent
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->indent;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->generate();
    }

}