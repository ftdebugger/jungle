<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:58
 */

namespace Jungle;


use Jungle\AST\ClassNode;
use Jungle\Exception\Lexer\InvalidToken;
use Jungle\Lexer\AbstractLexer;
use Jungle\Token\Token;

class Lexer extends AbstractLexer
{


    /**
     *
     */
    public function getAST()
    {
        try {
            $this->expectWhitespace();
            $node = $this->expectClass();
            var_dump($node);

        }catch (\Exception $e) {
            echo $e->getTraceAsString();
            throw $e;
        }
    }


    /**
     * Expect class
     */
    protected function expectClass()
    {
        $this->expectToken(Token::T_KEYWORD, false);
        $this->expectValue('class');
        $this->expectWhitespace(true);
        $this->expectToken(Token::T_STRING, false);

        $node = new ClassNode($this->parser->getCurrent(true));
        $this->expectWhitespace(false);
        $this->expectToken(Token::T_BLOCK_OPEN);
        $this->expectWhitespace(false);
        $this->expectToken(Token::T_BLOCK_CLOSE);

        return $node;
    }

}