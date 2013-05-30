<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/29/13 12:04
 */

namespace JungleTest\SLR;


use Jungle\Parser\Rule;
use Jungle\SLR\Situation;
use Jungle\SLR\SituationSet;
use Jungle\SLR\Table;
use Jungle\SLR\TransitionSet;

class TransitionSetTest extends \PHPUnit_Framework_TestCase
{

    public function testAddState()
    {
        $object = new TransitionSet(new Table());

        $stateA = new SituationSet();
        $situationA = new Situation(new Table(), new Rule());
        $stateA->add($situationA);

        $stateB = new SituationSet();
        $situationB = new Situation(new Table(), new Rule());
        $stateB->add($situationB);

        $this->assertCount(0, $object);
        $object->addState($stateA);
        $this->assertCount(1, $object);
        $object->addState($stateA);
        $this->assertCount(1, $object);
        $object->addState($stateB);
        $this->assertCount(2, $object);

    }
}
