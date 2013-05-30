<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:36
 */

namespace Jungle\Lexer;


use Jungle\Lexer\LexerInterface;
use Jungle\Stream\AbstractStream;
use Jungle\Token\Token;

class Regexp implements LexerInterface
{

    /**
     * @var int
     */
    protected $type;

    /**
     * @var string
     */
    protected $regexp;

    /**
     * @param $regexp
     * @param $type
     */
    public function __construct($regexp, $type)
    {
        $this->regexp = $regexp;
        $this->type = $type;
    }

    /**
     * @param AbstractStream $stream
     *
     * @return bool|Token
     */
    public function parse(AbstractStream $stream)
    {
        if (preg_match($this->regexp, $stream->getString(), $match)) {
            if (isset($match['value'])) {
                $value = $match['value'];
            }
            else {
                $value = $match[0];
            }

            $stream->skipString($value);

            return new Token($value, $this->type);
        }

        return false;
    }

}