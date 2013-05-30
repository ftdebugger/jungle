<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/29/13 12:16
 */

namespace Jungle\SLR;


class State
{

    /**
     * @var int
     */
    protected static $nextId = 0;

    /**
     * @var SituationSet
     */
    protected $situationSet;

    /**
     * @var State[]
     */
    protected $transitions = [];

    /**
     * @var int
     */
    protected $id;

    /**
     * @param SituationSet $situationSet
     */
    public function __construct($situationSet)
    {
        $this->situationSet = $situationSet;
        $this->id = self::$nextId++;
    }


    /**
     * @param string $token
     * @param State $state
     *
     * @throws \RuntimeException
     */
    public function addTransition($token, State $state)
    {
        if (isset($this->transitions[$token])) {
            throw new \RuntimeException('Transition already exists');
        }

        $this->transitions[$token] = $state;
    }

    /**
     * Return value of Transitions
     *
     * @return \Jungle\SLR\State[]
     */
    public function getTransitions()
    {
        return $this->transitions;
    }

    /**
     * Return value of SituationSet
     *
     * @return \Jungle\SLR\SituationSet
     */
    public function getSituationSet()
    {
        return $this->situationSet;
    }

    /**
     * Set value of Id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Return value of Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}