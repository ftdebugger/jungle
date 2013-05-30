<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 18:02
 */

namespace Jungle\Lexer;


use Jungle\Exception\Lexer\InvalidToken;
use Jungle\Parser;

abstract class AbstractLexer implements LexerInterface
{

    /**
     * @throws \Jungle\Exception\Lexer\InvalidToken
     */
    protected function invalidToken()
    {
        throw new InvalidToken('Another token expected');
    }

}