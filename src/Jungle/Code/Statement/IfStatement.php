<?php

namespace Jungle\Code\Statement;

use Jungle\Code\AbstractGenerator;
use Jungle\Code\Exception\InvalidArgumentException;
use Jungle\Code\GeneratorInterface;

/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 12:34
 */

class IfStatement extends AbstractGenerator
{

    /**
     * @var GeneratorInterface|string
     */
    protected $statement;

    /**
     * @var GeneratorInterface|string
     */
    protected $thenBlock;

    /**
     * @var GeneratorInterface|string
     */
    protected $elseBlock;

    /**
     * @param GeneratorInterface|string $statement
     * @param GeneratorInterface|string $thenBlock
     * @param null $elseBlock
     */
    public function __construct($statement = null, $thenBlock = null, $elseBlock = null)
    {
        $this->statement = $statement;
        $this->thenBlock = $thenBlock;
        $this->elseBlock = $elseBlock;
    }

    /**
     * @throws InvalidArgumentException
     * @return string
     */
    public function generate()
    {
        if (!$this->getStatement() || !$this->getThenBlock()) {
            throw new InvalidArgumentException('If block must have statement and then block');
        }

        $code = 'if (' . $this->getStatement() . ') {' . PHP_EOL;
        $code .= $this->indentBlock($this->getIndent() . $this->getThenBlock()) . PHP_EOL;
        $code .= '}';
        if ($this->getElseBlock()) {
            $code .= ' else {' . PHP_EOL;
            $code .= $this->indentBlock($this->getElseBlock()) . PHP_EOL;
            $code .= '}';
        }

        $code .= PHP_EOL;

        return $code;
    }

    /**
     * Set value of ElseBlock
     *
     * @param GeneratorInterface|string $elseBlock
     */
    public function setElseBlock($elseBlock)
    {
        $this->elseBlock = $elseBlock;
    }

    /**
     * Return value of ElseBlock
     *
     * @return GeneratorInterface|string
     */
    public function getElseBlock()
    {
        return $this->elseBlock;
    }

    /**
     * Set value of Statement
     *
     * @param GeneratorInterface|string $statement
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;
    }

    /**
     * Return value of Statement
     *
     * @return GeneratorInterface|string
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Set value of ThenBlock
     *
     * @param GeneratorInterface|string $thenBlock
     */
    public function setThenBlock($thenBlock)
    {
        $this->thenBlock = $thenBlock;
    }

    /**
     * Return value of ThenBlock
     *
     * @return GeneratorInterface|string
     */
    public function getThenBlock()
    {
        return $this->thenBlock;
    }


}