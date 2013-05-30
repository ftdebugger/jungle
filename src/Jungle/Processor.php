<?php

namespace Jungle;


class Processor
{

    /**
     * State table
     *
     * @var array
     */
    protected $table = array();

    /**
     * @var \SplStack
     */
    protected $stack;

    /**
     * Tokens
     *
     * @var array
     */
    protected $tokens;

    /**
     * Parse language
     *
     * @param string $content
     */
    public function parse($content)
    {
        $this->tokenizer($content);
        $this->stack = new \SplStack();

    }

    /**
     *
     */
    protected function tokenizer()
    {
        $this->tokens[] = [];
    }

}