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
use Jungle\Syntax\Rule;
use Jungle\Syntax\RuleContainer;

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
     * @var RuleContainer[]
     */
    protected $rules = [];

    /**
     * @var LexerFactory
     */
    protected $lexerFactory;

    /**
     * @var array
     */
    protected $aliases = array();

    /**
     * @var string
     */
    protected $whitespace = 'ignore';

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
        if (isset($this->config['whitespace'])) {
            $this->whitespace = $this->config['whitespace'];
        }

        // init lexer
        if (isset($this->config['terminals']) && is_array($this->config['terminals'])) {
            foreach (array_keys($this->config['terminals']) as $index => $lexer) {
                $this->getTerminal($lexer)->setWeight($index + 1);
            }
        }

        // init parser
        if (isset($this->config['rules']) && is_array($this->config['rules'])) {
            foreach (array_keys($this->config['rules']) as $parser) {
                $this->getRule($parser);
            }
        }
    }

    /**
     * @param string $name
     *
     * @return \Jungle\Syntax\RuleContainer
     */
    protected function initStatement($name)
    {
        if (isset($this->config['rules'][$name])) {
            return $this->getRule($name);
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
     * @return \Jungle\Syntax\RuleContainer
     */
    public function getRule($name)
    {
        if (!isset($this->rules[$name])) {
            $this->rules[$name] = new RuleContainer();
            $this->rules[$name]->setName($name);

            foreach ($this->config['rules'][$name] as $ruleString) {
                $expression = new Rule();
                $expression->parseStatement($ruleString);

                $this->rules[$name]->addExpression($expression);

                foreach ($expression->getTokens() as $token) {
                    $this->initStatement($token);
                }
            }
        }

        return $this->rules[$name];
    }

    /**
     * @return RuleContainer[]
     */
    public function getRules()
    {
        return $this->rules;
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
                return $a->getWeight() - $b->getWeight();
            }
        );

        return $this->terminals;
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

    /**
     * @return bool
     */
    public function isIgnoreWhitespace()
    {
        return $this->whitespace == 'ignore';
    }

    /**
     * @return bool
     */
    public function isKeepWhitespace()
    {
        return $this->whitespace == 'keep';
    }
}