<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 17:10
 */

namespace Jungle;


use Jungle\Lexer\AbstractLexer;
use Jungle\Lexer\LexerFactory;
use Jungle\Lexer\LexerInterface;
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
     * @var LexerInterface[]
     */
    protected $terminals = [];

    /**
     * @var ExpressionContainer[]
     */
    protected $nonTerminals = [];

    /**
     * @var LexerFactory
     */
    protected $lexerFactory;

    /**
     * @var array
     */
    protected $aliases = array();

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
//        // init lexer
//        if (isset($this->config['terminals']) && is_array($this->config['terminals'])) {
//            foreach (array_keys($this->config['terminals']) as $lexer) {
//                $this->getTerminal($lexer);
//            }
//        }
        // init parser
        if (isset($this->config['nonTerminals']) && is_array($this->config['nonTerminals'])) {
            foreach (array_keys($this->config['nonTerminals']) as $parser) {
                $this->getNonTerminal($parser);
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
        if (isset($this->config['nonTerminals'][$name])) {
            return $this->getNonTerminal($name);
        }

        return $this->getTerminal($name);
    }

    /**
     * @param string $name
     *
     * @return \Jungle\Lexer\LexerInterface
     */
    protected function getTerminal($name)
    {
        if (!isset($this->terminals[$name])) {
            if (isset($this->config['terminals'][$name])) {
                $this->terminals[$name] = $this->getLexerFactory()->getLexer(
                    $name, $this->config['terminals'][$name]
                );
            } else {
                $this->terminals[$name] = $this->getLexerFactory()->getLexer($name, $name);
            }

            $this->terminals[$name]->setId($this->getAlias($name));
        }

        return $this->terminals[$name];
    }

    /**
     * @param string $name
     *
     * @return \Jungle\Parser\ExpressionContainer
     */
    public function getNonTerminal($name)
    {
        if (!isset($this->nonTerminals[$name])) {
            $this->nonTerminals[$name] = new ExpressionContainer();
            $this->nonTerminals[$name]->setName($name);

            foreach ($this->config['nonTerminals'][$name] as $ruleString) {
                $expression = new Expression();
                $expression->parseStatement($ruleString);

                $this->nonTerminals[$name]->addExpression($expression);

                foreach ($expression->getTokens() as $token) {
                    $this->initStatement($token);
                }
            }
        }

        return $this->nonTerminals[$name];
    }

    /**
     * @return ExpressionContainer[]
     */
    public function getNonTerminals()
    {
        return $this->nonTerminals;
    }

    /**
     * Return value of Terminals
     *
     * @return LexerInterface[]
     */
    public function getTerminals()
    {
        usort(
            $this->terminals, function ($a, $b) {
                /** @var $a AbstractLexer */
                /** @var $b AbstractLexer */
                return $a->getWeight()-$b->getWeight();
            }
        );

        return $this->terminals;
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

    /**
     * @param string $name
     *
     * @return int
     */
    public function getAlias($name)
    {
        $name = trim($name);

        $alias = array_search($name, $this->aliases);
        if ($alias === false) {
            return array_push($this->aliases, $name) - 1;
        }

        return $alias;
    }

}