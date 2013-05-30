<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 17:50
 */

namespace Jungle\Parser;


class RuleSet
{

    /**
     * @var Rule[]
     */
    protected $rules = [];

    /**
     * @param string $id
     *
     * @return \Jungle\Parser\Rule
     */
    public function getRule($id)
    {
        return $this->rules[$id];
    }

    /**
     * @param Rule $rule
     */
    public function addRule(Rule $rule)
    {
        $this->rules[$rule->getId()] = $rule;
    }

    /**
     * Set value of Rules
     *
     * @param \Jungle\Parser\Rule[] $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
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