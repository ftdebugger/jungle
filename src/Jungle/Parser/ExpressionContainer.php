<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 18:20
 */

namespace Jungle\Parser;


class ExpressionContainer
{

    /**
     * @var Expression[]
     */
    protected $expressions;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param Expression $expression
     */
    public function addExpression(Expression $expression)
    {
        $this->expressions[] = $expression;
    }

    /**
     * Set value of Expressions
     *
     * @param \Jungle\Parser\Expression[] $expressions
     */
    public function setExpressions($expressions)
    {
        $this->expressions = $expressions;
    }

    /**
     * Return value of Expressions
     *
     * @return \Jungle\Parser\Expression[]
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