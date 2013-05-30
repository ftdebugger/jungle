<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 19:16
 */

namespace Jungle\SLR;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use SplQueue;
use Traversable;

class TransitionSet implements Countable, IteratorAggregate
{

    /**
     * @var Table
     */
    protected $table;

    /**
     * @var State[]
     */
    protected $states;

    /**
     * @var SplQueue
     */
    protected $stateQueue;

    /**
     * @param Table $table
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->stateQueue = new SplQueue();
    }

    /**
     * Process
     */
    public function process()
    {
        $situation = new Situation($this->table, $this->table->getStartRule());
        $this->addState($situation->closure());

        while (!$this->stateQueue->isEmpty()) {
            /** @var State $state */
            $state = $this->stateQueue->dequeue();
            foreach ($state->getSituationSet()->getNextTokens() as $next) {
                $transition = $this->addState($state->getSituationSet()->transition($next));
                $state->addTransition($next, $transition);
            }
        }
    }

    /**
     * @param SituationSet $situationSet
     *
     * @return \Jungle\SLR\State
     */
    public function addState(SituationSet $situationSet)
    {
        $key = $situationSet->getKey();

        if (!isset($this->states[$key])) {
            $this->states[$key] = new State($situationSet);
            $this->stateQueue->enqueue($this->states[$key]);
        }

        return $this->states[$key];
    }

    /**
     * Count elements of an object
     */
    public function count()
    {
        return count($this->states);
    }


    /**
     * Retrieve an external iterator
     *
     * @return Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->states);
    }
}