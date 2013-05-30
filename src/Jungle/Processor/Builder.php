<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 13:38
 */

namespace Jungle\Processor;


use Jungle\Code\Statement\Container;
use Jungle\Code\Statement\FunctionStatement;
use Jungle\Code\Statement\IfStatement;
use Jungle\Code\Statement\RawBlock;
use Jungle\Code\Statement\ScalarStatement;
use Jungle\Code\Statement\VariableStatement;
use Jungle\Code\Statement\WhileStatement;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Reflection\ClassReflection;

class Builder
{

    /**
     * @var array
     */
    protected $tokensConvert = [];

    /**
     * @param array $config
     *
     * @return \Zend\Code\Generator\ClassGenerator
     */
    public function build(array $config)
    {
        $class = new ClassGenerator('Test');
        $class->addPropertyFromGenerator($this->getActionTableProperty());
        $class->addPropertyFromGenerator($this->getStackProperty());

        $tokenizer = $this->getTokenizerMethod($config['tokens']);

//        $class->addMethodFromGenerator($this->constructMethod());
        $class->addMethodFromGenerator($tokenizer);

        return $class;
    }

    /**
     * @return PropertyGenerator
     */
    protected function getActionTableProperty()
    {
        $property = new PropertyGenerator('action', [], PropertyGenerator::FLAG_PROTECTED);
        $property->setDocBlock(new DocBlockGenerator('Syntax analyse action table'));

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
     * @param array $tokens
     *
     * @return MethodGenerator
     */
    protected function getTokenizerMethod(array $tokens)
    {
        $methodBody = new Container();
        $methodBody->addLine(new RawBlock('$tokens = [];'));

        $while = new WhileStatement(new RawBlock('strlen($data) !== 0'));
        $while->setBody($whileBody = new Container());

        $methodBody->addLine($while);

        $method = new MethodGenerator('tokenizer', ['data']);
        $method->setBody($methodBody);

        /** @var IfStatement $lastIf */
        $lastIf = null;

        foreach ($tokens as $tokenName => $token) {
            $statement = new IfStatement();
            if ($token[0] == '/') {
                $function = new FunctionStatement('preg_match',
                    array(
                         new ScalarStatement($token),
                         new VariableStatement('data'),
                         new VariableStatement('match')
                    )
                );
                $then = new RawBlock('$token = [' . $this->getTokenId($tokenName) . ', $match[0]];');
            } else {
                $function = new FunctionStatement('substr', [new VariableStatement('data'), 0, strlen($token)]);
                $function = new RawBlock(var_export($token, true) . ' === ' . $function);
                $then = new RawBlock('$token = [' . $this->getTokenId($tokenName) . ', ' . var_export($token, true)
                . '];');
            }

            $statement->setStatement($function);
            $statement->setThenBlock($then);

            if (null === $lastIf) {
                $lastIf = $statement;
                $whileBody->addLine($lastIf);
            } else {
                $lastIf->setElseBlock($statement);
                $lastIf = $statement;
            }
        }

        if ($lastIf) {
            $lastIf->setElseBlock('throw new \Exception("Syntax error");');
        }

        $whileBody->addLine(new RawBlock('$data = substr($data, strlen($token[1]));'));
        $whileBody->addLine(new RawBlock('$tokens[] = $token;'));

        $methodBody->addLine('return $tokens;');

        return $method;
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

}