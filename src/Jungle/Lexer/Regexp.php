<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:36
 */

namespace Jungle\Lexer;


use Jungle\Code\GeneratorInterface;
use Jungle\Code\Statement\FunctionStatement;
use Jungle\Code\Statement\IfStatement;
use Jungle\Code\Statement\RawBlock;
use Jungle\Code\Statement\ScalarStatement;
use Jungle\Code\Statement\VariableStatement;
use Jungle\Lexer\LexerInterface;

class Regexp extends AbstractLexer implements LexerInterface
{

    /**
     * @var int
     */
    protected $id;

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
     * Set value of Id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \Jungle\Code\GeneratorInterface $input
     *
     * @return string
     */
    public function getGenerator(GeneratorInterface $input)
    {
        $function = new FunctionStatement('preg_match',
            array(
                 new ScalarStatement($this->regexp),
                 $input,
                 new VariableStatement('match')
            )
        );
        $then = new RawBlock('return [' . $this->id . ', $match[0]];');

        return new IfStatement($function, $then);
    }


}