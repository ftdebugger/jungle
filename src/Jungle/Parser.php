<?php

namespace Jungle;
use Jungle\Exception\RuntimeException;
use Jungle\Lexer\LexerInterface;
use Jungle\Stream\AbstractStream;
use Jungle\Token\Token;

/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:01
 */

class Parser
{

    /**
     * @var AbstractStream
     */
    protected $stream;

    /**
     * @var LexerInterface[]
     */
    protected $parsers = [];

    /**
     * @var array
     */
    protected $tokens = [];

    /**
     * @var int
     */
    protected $current = 0;

    /**
     * @var \SplStack
     */
    protected $stack;

    /**
     *
     */
    public function __construct()
    {
        $this->stack = new \SplStack();
    }

    /**
     * @param \Jungle\Lexer\LexerInterface $parser
     */
    public function addParser(LexerInterface $parser)
    {
        $this->parsers[] = $parser;
    }

    /**
     * @param Stream\AbstractStream $stream
     *
     * @throws Exception\RuntimeException
     * @return array
     */
    public function parse(AbstractStream $stream)
    {
        $this->stream = $stream;

        while (!$this->stream->isEmpty()) {
            $token = null;

            foreach ($this->parsers as $parser) {
                $token = $parser->parse($this->stream);
                if ($token) {
                    $this->tokens[] = $token;
                    break;
                }
            }

            if (!$token) {
                $near = $this->stream->getString();
                $near = substr($near, 0, 50);

                throw new RuntimeException('Cannot parse near "' . $near . '"');
            }
        }
    }

    /**
     * @param bool $next
     *
     * @return Token
     */
    public function getCurrent($next = false)
    {
        $token = $this->tokens[$this->current];
        if ($next) {
            $this->next();
        }

        return $token;

    }

    /**
     * @return Token
     */
    public function getNext()
    {
        return $this->tokens[$this->current + 1];
    }

    /**
     * Next token
     */
    public function next()
    {
        $this->current++;
    }

    /**
     * Save current position
     */
    public function save()
    {
        $this->stack->push($this->current);
    }

    /**
     * Restore current position
     */
    public function restore()
    {
        $this->current = $this->stack->pop();
    }

}