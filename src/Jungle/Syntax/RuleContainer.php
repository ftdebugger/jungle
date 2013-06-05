<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 18:20
 */

namespace Jungle\Syntax;


use Jungle\Syntax\Rule;

class RuleContainer
{

    /**
     * @var Rule[]
     */
    protected $expressions;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param Rule $expression
     */
    public function addExpression(Rule $expression)
    {
        $this->expressions[] = $expression;
    }

    /**
     * Set value of Expressions
     *
     * @param \Jungle\Syntax\Rule[] $expressions
     */
    public function setExpressions($expressions)
    {
        $this->expressions = $expressions;
    }

    /**
     * Return value of Expressions
     *
     * @return \Jungle\Syntax\Rule[]
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * Set value of Name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Return value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}