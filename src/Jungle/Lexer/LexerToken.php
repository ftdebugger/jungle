<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/22/13 18:10
 */

namespace Jungle\Lexer;


use Jungle\AST\Leaf;
use Jungle\AST\NodeInterface;
use Jungle\Exception\Lexer\InvalidToken;
use Jungle\Parser;

class LexerToken extends AbstractLexer
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param Parser $parser
     *
     * @throws InvalidToken
     * @return NodeInterface
     */
    public function getAST(Parser $parser)
    {
        if ($parser->getCurrent()->getType() != $this->name) {
            $this->invalidToken();
        }

        return new Leaf($parser->getCurrent(true));
    }

    /**
     * Return value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}