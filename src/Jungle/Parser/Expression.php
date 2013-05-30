<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 18:16
 */

namespace Jungle\Parser;


class Expression
{

    /**
     * @var array
     */
    protected $tokens = array();

    /**
     * @var string
     */
    protected $reduce;

    /**
     * @var string
     */
    protected $callback;

    /**
     * @param string $ruleString
     */
    public function parseStatement($ruleString)
    {
        if (preg_match("#^(?<rule>.+)\\{(?<callback>.+)\\}$#mis", $ruleString, $match)) {
            $this->callback = $match['callback'];
            $ruleString = $match['rule'];
        } else {
            $this->callback = '$$ = $1;';
        }

        $ruleString = trim($ruleString);

        if (strlen($ruleString) > 0) {
            $this->tokens = preg_split("#[ \t]+#", $ruleString);
        }
    }

    /**
     * Set value of Reduce
     *
     * @param string $reduce
     */
    public function setReduce($reduce)
    {
        $this->reduce = $reduce;
    }

    /**
     * Return value of Reduce
     *
     * @return string
     */
    public function getReduce()
    {
        return $this->reduce;
    }

    /**
     * Set value of Tokens
     *
     * @param array $tokens
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * Return value of Tokens
     *
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Return value of Callback
     *
     * @return string
     */
    public function getCallback()
    {
        return $this->callback;
    }

}