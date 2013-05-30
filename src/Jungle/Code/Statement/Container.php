<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 14:16
 */

namespace Jungle\Code\Statement;


use Jungle\Code\AbstractGenerator;
use Jungle\Code\GeneratorInterface;

class Container extends AbstractGenerator
{

    /**
     * @var GeneratorInterface[]
     */
    protected $lines;

    /**
     * @return string
     */
    public function generate()
    {
        return implode(PHP_EOL, $this->lines);
    }

    /**
     * Set value of Lines
     *
     * @param GeneratorInterface $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }

    /**
     * Return value of Lines
     *
     * @return GeneratorInterface
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param string|GeneratorInterface $line
     */
    public function addLine($line)
    {
        $this->lines[] = $line;
    }

}