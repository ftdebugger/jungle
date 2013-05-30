<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 17:10
 */

namespace Jungle;


use Jungle\Lexer\LexerFactory;
use Jungle\Parser\Expression;
use Jungle\Parser\ExpressionContainer;
use Jungle\Parser\Rule;
use Jungle\Parser\RuleSet;

class Syntax
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $lexers = [];

    /**
     * @var ExpressionContainer[]
     */
    protected $tokens = [];

    /**
     * @var LexerFactory
     */
    protected $lexerFactory;

    /**
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->parse();
    }

    /**
     * Parse config
     */
    protected function parse()
    {
        // init lexer
        if (isset($this->config['lexer']) && is_array($this->config['lexer'])) {
            foreach (array_keys($this->config['lexer']) as $lexer) {
                $this->getLexer($lexer);
            }
        }
        // init parser
        if (isset($this->config['parser']) && is_array($this->config['parser'])) {
            foreach (array_keys($this->config['parser']) as $parser) {
                $this->getToken($parser);
            }
        }
    }

    /**
     * @param string $name
     *
     * @return \Jungle\Parser\ExpressionContainer
     */
    protected function initStatement($name)
    {
        if (isset($this->tokens[$name])) {
            return $this->tokens[$name];
        }

        if (isset($this->config['parser'][$name])) {
            return $this->getToken($name);
        }

        return $this->getLexer($name);
    }

    /**
     * @param string $lexerName
     */
    protected function getLexer($lexerName)
    {
        if (!isset($this->lexers[$lexerName])) {
            if (isset($this->config['lexer'][$lexerName])) {
                $this->lexers[$lexerName] = $this->getLexerFactory()->getLexer(
                    $lexerName, $this->config['lexer'][$lexerName]
                );
            } else {
                $this->lexers[$lexerName] = $this->getLexerFactory()->getLexer($lexerName, $lexerName);
            }
        }

        return $this->lexers[$lexerName];
    }

    /**
     * @param string $parserName
     *
     * @return \Jungle\Parser\ExpressionContainer
     */
    public function getToken($parserName)
    {
        if (!isset($this->tokens[$parserName])) {
            $this->tokens[$parserName] = new ExpressionContainer();
            $this->tokens[$parserName]->setName($parserName);

            foreach ($this->config['parser'][$parserName] as $ruleString) {
                $expression = new Expression();
                $expression->parseStatement($ruleString);

                $this->tokens[$parserName]->addExpression($expression);

                foreach ($expression->getTokens() as $token) {
                    $this->initStatement($token);
                }
            }
        }

        return $this->tokens[$parserName];
    }

    /**
     * @return ExpressionContainer[]
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param string $parserName
     * @param string $ruleString
     *
     * @return Rule
     */
    protected function getRule($parserName, $ruleString)
    {
        $rule = new Rule();
        $rule->setLeft($parserName);
        $rule->setRight(
            array_map(
                function ($rule) {
                    return $this->initStatement($rule);
                }, preg_split("#[ \t]+#", $ruleString)
            )
        );

        return $rule;
    }

    /**
     * Set value of LexerFactory
     *
     * @param \Jungle\Lexer\LexerFactory $lexerFactory
     */
    public function setLexerFactory($lexerFactory)
    {
        $this->lexerFactory = $lexerFactory;
    }

    /**
     * Return value of LexerFactory
     *
     * @return \Jungle\Lexer\LexerFactory
     */
    public function getLexerFactory()
    {
        if (null === $this->lexerFactory) {
            $this->lexerFactory = new LexerFactory();
        }
        return $this->lexerFactory;
    }

}