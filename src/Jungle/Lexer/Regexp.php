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
        $then = new RawBlock('return [' . var_export($this->type, true) . ', $match[0]];');

        return new IfStatement($function, $then);
    }


}