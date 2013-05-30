<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:50
 */

namespace Jungle\Lexer;


use Jungle\Lexer\LexerInterface;
use Jungle\Stream\AbstractStream;
use Jungle\Token\Token;

class String implements LexerInterface
{
    /**
     * @var string
     */
    protected $value = '';

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
     * @param AbstractStream $stream
     *
     * @return bool|Token
     */
    public function parse(AbstractStream $stream)
    {
        if ($stream->compareString($this->value)) {
            $stream->skipString($this->value);
            return new Token($this->value, $this->type);
        }

        return false;
    }

}