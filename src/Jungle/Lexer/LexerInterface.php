<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:19
 */

namespace Jungle\Lexer;


use Jungle\Stream\AbstractStream;
use Jungle\Token\Token;

interface LexerInterface
{

    /**
     * @param AbstractStream $stream
     *
     * @return bool|Token
     */
    public function parse(AbstractStream $stream);

}