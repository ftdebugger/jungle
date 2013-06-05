<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/31/13 17:59
 */

namespace Jungle\Example\CSS;


class Block
{

    /**
     * @var Rule[]
     */
    protected $rules;

    /**
     * @var Selector[]
     */
    protected $selectors;

    /**
     * @param $selectors
     * @param $rules
     */
    public function __construct($selectors, $rules)
    {
        $this->selectors = $selectors;
        $this->rules = $rules;
    }

    /**
     * Return value of Rules
     *
     * @return \Jungle\Example\CSS\Rule[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Return value of Selectors
     *
     * @return \Jungle\Example\CSS\Selector[]
     */
    public function getSelectors()
    {
        return $this->selectors;
    }

    /**
     * @param string $name
     * @return Rule|null
     */
    public function getRule($name)
    {
        foreach ($this->getRules() as $rule) {
            if ($rule->getKey() == $name) {
                return $rule;
            }
        }

        return null;
    }


}