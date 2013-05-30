<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 18:04
 */

namespace Jungle\Parser\RuleSet;


use Jungle\Parser\RuleSet;

class Container
{

    /**
     * @var RuleSet[]
     */
    protected $rules = [];

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasRuleSet($name)
    {
        return isset($this->rules[$name]);
    }

    /**
     * @param string $name
     *
     * @return RuleSet
     */
    public function getRuleSet($name)
    {
        if (!isset($this->rules[$name])) {
            $this->rules[$name] = new RuleSet();
        }

        return $this->rules[$name];
    }

    /**
     * Return value of Rules
     *
     * @return \Jungle\Parser\Rule[]
     */
    public function getRules()
    {
        return $this->rules;
    }

}