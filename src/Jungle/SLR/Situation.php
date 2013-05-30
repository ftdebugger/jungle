<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 19:18
 */

namespace Jungle\SLR;


use Jungle\Parser\Rule;

class Situation
{

    /**
     * @var Table
     */
    protected $table;

    /**
     * @var Rule
     */
    protected $rule;

    /**
     * @var int
     */
    protected $marker;

    /**
     * @param Table $table
     * @param Rule $rule
     * @param integer $marker
     */
    public function __construct($table, Rule $rule, $marker = 0)
    {
        $this->marker = $marker;
        $this->rule = $rule;
        $this->table = $table;
    }

    /**
     * @return SituationSet
     */
    public function closure()
    {
        $state = new SituationSet();
        $state->add($this);

        return $state->closure();
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->rule->getId() . '.' . $this->marker;
    }

    /**
     * @return bool
     */
    public function hasNext()
    {
        return $this->marker < $this->rule->getRightCount();
    }

    /**
     * @return string|bool
     */
    public function next()
    {
        return $this->rule->getByMarker($this->marker);
    }

    /**
     * @return Situation|bool
     */
    public function step()
    {
        if (!$this->hasNext()) {
            return false;
        }

        return new Situation($this->getTable(), $this->rule, $this->marker + 1);
    }

    /**
     * Return value of Table
     *
     * @return \Jungle\SLR\Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Return value of Rule
     *
     * @return \Jungle\Parser\Rule
     */
    public function getRule()
    {
        return $this->rule;
    }


}