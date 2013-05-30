<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/28/13 16:13
 */

namespace Jungle\SLR;


use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

class SituationSet implements Countable, IteratorAggregate
{

    /**
     * @var Situation[]
     */
    protected $situations = [];

    /**
     * @var string
     */
    protected $key = '';

    /**
     * @param Situation $situation
     *
     * @return bool
     */
    public function add(Situation $situation)
    {
        $key = $situation->getKey();
        if (isset($this->situations[$key])) {
            return false;
        }

        $this->invalidateKey();
        $this->situations[$key] = $situation;

        return true;
    }

    /**
     * @return void
     */
    public function invalidateKey()
    {
        $this->key = null;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        if (!$this->key) {
            $parts = [];
            foreach ($this->situations as $situation) {
                $parts[] = $situation->getKey();
            }

            $this->key = implode('|', $parts);
        }

        return $this->key;
    }

    /**
     * @return SituationSet
     */
    public function closure()
    {
        $state = new SituationSet();

        $queue = $this->getQueue();

        while (!$queue->isEmpty()) {
            /** @var Situation $situation */
            $situation = $queue->dequeue();

            // if not in queue yet
            if ($state->add($situation)) {
                $next = $situation->next();
                if ($next) {
                    foreach ($situation->getTable()->getLeftRulesByName($next) as $rule) {
                        $queue->enqueue(new Situation($situation->getTable(), $rule, 0));
                    }
                }
            }
        }

        return $state;
    }

    /**
     * @param string $token
     *
     * @return SituationSet
     */
    public function transition($token)
    {
        $set = new SituationSet();

        foreach ($this->situations as $situation) {
            if ($situation->next() == $token) {
                $next = $situation->step();
                if ($next) {
                    $set->add($next);
                }
            }
        }

        return $set->closure();
    }

    /**
     * @return \SplQueue
     */
    protected function getQueue()
    {
        $queue = new \SplQueue();
        foreach ($this->situations as $situation) {
            $queue->enqueue($situation);
        }

        return $queue;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->situations);
    }

    /**
     * @return string[]
     */
    public function getNextTokens()
    {
        $tokens = array();
        foreach ($this->situations as $situation) {
            $token = $situation->next();
            if ($token) {
                $tokens[] = $token;
            }
        }

        return array_unique($tokens);
    }

    /**
     * Retrieve an external iterator
     *
     * @return Traversable|Situation[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->situations);
    }
}