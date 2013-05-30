<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 13:38
 */

namespace Jungle\Processor;


use Jungle\Code\PropertyValueGenerator;
use Jungle\Code\Statement\Container;
use Jungle\Code\Statement\RawBlock;
use Jungle\Code\Statement\VariableStatement;
use Jungle\Code\Statement\WhileStatement;
use Jungle\SLR\Table;
use Jungle\Syntax;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\ValueGenerator;

class Builder
{

    /**
     * @var array
     */
    protected $tokensConvert = [];

    /**
     * @var ClassGenerator
     */
    protected $class;

    /**
     * @param \Jungle\Syntax $syntax
     * @param \Jungle\SLR\Table $table
     *
     * @return \Zend\Code\Generator\ClassGenerator
     */
    public function build(Syntax $syntax, Table $table)
    {
        $this->class = new ClassGenerator('Test');
        $this->class->addPropertyFromGenerator($this->getActionTableProperty($table));
        $this->class->addPropertyFromGenerator($this->getStackProperty());

        $this->buildParseMethod();
        $this->buildTokenizerMethod($syntax);
        $this->buildGetNextTokenMethod($syntax);
        $this->buildReduces($table->getReduces());

        return $this->class;
    }

    /**
     * @return PropertyGenerator
     */
    protected function getActionTableProperty(Table $table)
    {
        $property = new PropertyGenerator('action', [], PropertyGenerator::FLAG_PROTECTED);
        $property->setDocBlock(new DocBlockGenerator('Syntax analyse action table'));
        $property->setDefaultValue(new PropertyValueGenerator($table->getTable()));

        return $property;
    }

    /**
     * @return PropertyGenerator
     */
    protected function getStackProperty()
    {
        $property = new PropertyGenerator('stack', null, PropertyGenerator::FLAG_PROTECTED);
        $property->setDocBlock(
            new DocBlockGenerator(
                'Tokens stack', '',
                array(
                     array(
                         'name' => 'var',
                         'description' => '\SplStack'
                     )
                )
            )
        );

        return $property;
    }

    protected function constructMethod()
    {
        $method = new MethodGenerator('__construct');

        return $method;
    }

    /**
     */
    protected function buildTokenizerMethod(Syntax $syntax)
    {
        $while = new WhileStatement(new RawBlock('strlen($data) !== 0'));
        $while->setBody($whileBody = new Container());

        $whileBody->addLine(new RawBlock('$token = $this->getNextToken($data);'));
        $whileBody->addLine(new RawBlock('$data = trim(substr($data, strlen($token[1])));'));
        $whileBody->addLine(new RawBlock('$tokens[] = $token;'));

        $methodBody = new Container();
        $methodBody->addLine(new RawBlock('$tokens = [];'));
        $methodBody->addLine($while);
        $methodBody->addLine(new RawBlock('$tokens[] = array('. $syntax->getAlias('__END__') .', \'\');'));
        $methodBody->addLine('return $tokens;');

        $method = new MethodGenerator('tokenizer', ['data']);
        $method->setBody($methodBody);

        $this->class->addMethodFromGenerator($method);
    }

    protected function buildGetNextTokenMethod(Syntax $syntax)
    {
        $method = new MethodGenerator('getNextToken', ['data']);
        $method->setBody($methodBody = new Container());

        foreach ($syntax->getTerminals() as $terminal) {
            $statement = $terminal->getGenerator(new VariableStatement('data'));
            $methodBody->addLine($statement);
        }

        $methodBody->addLine('throw new \Exception("Syntax error");');

        $this->class->addMethodFromGenerator($method);
    }

    /**
     * @param string $token
     *
     * @return int
     */
    protected function getTokenId($token)
    {
        if (!isset($this->tokensConvert[$token])) {
            $this->tokensConvert[$token] = count($this->tokensConvert) + 1;
        }
        return $this->tokensConvert[$token];
    }

    /**
     * @param array $reduces
     */
    protected function buildReduces(array $reduces)
    {
        $this->buildReduceMethod();

        foreach ($reduces as $id => $body) {
            $count = 0;

            $body = preg_replace_callback(
                "#\\$(?<index>\\d+)#", function ($match) use (&$count) {
                    $count = max($count, $match['index']);

                    return '$' . chr(ord('a') + $match['index'] - 1);
                }, $body
            );

            $body = str_replace('$$', '$returnValue', $body) . PHP_EOL . 'return $returnValue;';

            $params = array();
            for ($i = 0; $i < $count; $i++) {
                $params[] = new ParameterGenerator(chr(ord('a') + $i), 'int', new ValueGenerator());
            }

            $method = new MethodGenerator('reduce' . $id, $params, MethodGenerator::FLAG_PROTECTED);
            $method->setBody($body);

            $this->class->addMethodFromGenerator($method);
        }
    }

    protected function buildReduceMethod()
    {
        $method = new MethodGenerator('reduce', ['count', 'index'], MethodGenerator::FLAG_PROTECTED);
        $body = <<<'EOF'
$args = array();
for ($i = 0; $i < $count; $i++) {
    $this->stack->pop();
    $args[] = $this->stack->pop();
}

return call_user_func_array([$this, 'reduce' . $index], array_reverse($args));
EOF;
        $method->setBody($body);
        $this->class->addMethodFromGenerator($method);

    }

    /**
     *
     */
    protected function buildParseMethod()
    {
        $method = new MethodGenerator('parse', ['data']);
        $body = <<<'EOF'
$tokens = $this->tokenizer($data);
$this->stack = new \SplStack();
$this->stack->push(0);

while (true) {
    $token = $tokens[0];
    $state = $this->stack->top();
    $terminal = $token[0];

    if (!isset($this->action[$state][$terminal])) {
        throw new \Exception('Token not allowed here (' . $token[1] . ')');
    }

    $action = $this->action[$state][$terminal];
    if ($action[0] === 0) {
        $this->stack->push($token[1]);
        $this->stack->push($action[1]);
        array_shift($tokens);
    } elseif ($action[0] === 1) {
        $value = $this->reduce($action[2], $action[1]);
        array_unshift($tokens, array($action[3], $value));
    } elseif ($action[0] === 2) {
        $this->stack->pop();
        return $this->stack->pop();
    } else {
        throw new \RuntimeException('Cannot compile');
    }
}

throw new \RuntimeException('Cannot compile. EOF');
EOF;

        $method->setBody($body);
        $this->class->addMethodFromGenerator($method);
    }

}