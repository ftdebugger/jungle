<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/22/13 17:39
 */

namespace Jungle\Lexer;


use Jungle\Exception\RuntimeException;

class Builder
{

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var LexerInterface[]
     */
    protected $lexers = array();

    /**
     * @param array $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }


    /**
     * @return LexerInterface
     */
    public function build()
    {
        return $this->getLexer('global');
    }

    /**
     * @param string $lexerName
     *
     * @throws \RuntimeException
     * @return \Jungle\Lexer\AbstractLexer
     */
    protected function getLexer($lexerName)
    {
        if (!isset($this->lexers[$lexerName])) {
            $lexer = new OrContainer();
            $this->lexers[$lexerName] = $lexer;

            foreach ($this->options['lexers'][$lexerName] as $lexerString) {
                $lexer->addLexer($this->parseStatement($lexerString));
            }
        }

        return $this->lexers[$lexerName];
    }

    /**
     * @param string $tokenName
     *
     * @return LexerInterface
     */
    protected function getToken($tokenName)
    {
        if (!isset($this->lexers[$tokenName])) {
            $this->lexers[$tokenName] = new LexerToken($tokenName);
        }

        return $this->lexers[$tokenName];
    }

    /**
     * @param string $name
     *
     * @return LexerInterface
     * @throws \RuntimeException
     */
    protected function getStatement($name)
    {
        if ($this->hasLexer($name)) {
            return $this->getLexer($name);
        }

        if ($this->hasToken($name)) {
            return $this->getToken($name);
        }

        throw new \RuntimeException('Cannot find lexer or token "' . $name . '"');
    }

    protected function parseStatement($statementName)
    {
        $statementName = trim($statementName);
        $statement = preg_split('#([ ]*\|[ ]*|[ ]+)#', $statementName, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (count($statement) == 1) {
            return $this->getStatement($statementName);
        }

        if (trim($statement[1]) == '|') {
            $lexer = new OrContainer();
        } elseif (trim($statement[1]) == '') {
            $lexer = new AndContainer();
        } else {
            throw new RuntimeException('Parse statement error');
        }

        $lexer->addLexer($this->getStatement($statement[0]));
        $lexer->addLexer($this->parseStatement(implode("", array_slice($statement, 2))));

        return $lexer;
    }

    /**
     * @param string $lexerName
     *
     * @return bool
     */
    protected function hasLexer($lexerName)
    {
        return isset($this->options['lexers'][$lexerName]);
    }

    /**
     * @param string $lexerName
     *
     * @return bool
     */
    protected function hasToken($lexerName)
    {
        return isset($this->options['tokens'][$lexerName]);
    }

}