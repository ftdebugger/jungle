<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:50
 */

namespace Jungle\Lexer;


use Jungle\Code\GeneratorInterface;
use Jungle\Code\Statement\FunctionStatement;
use Jungle\Code\Statement\IfStatement;
use Jungle\Code\Statement\RawBlock;
use Jungle\Lexer\LexerInterface;

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
     * @param \Jungle\Code\GeneratorInterface $input
     *
     * @return string
     */
    public function getGenerator(GeneratorInterface $input)
    {
        $function = new FunctionStatement('substr', [$input, 0, strlen($this->value)]);
        $function = new RawBlock(var_export($this->type, true) . ' === ' . $function);
        $then = new RawBlock('return [' . var_export($this->type, true) . ', ' . var_export($this->value, true)
        . '];');

        return new IfStatement($function, $then);
    }


}