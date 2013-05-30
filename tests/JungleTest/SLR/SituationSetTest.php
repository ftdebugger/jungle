<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/28/13 16:46
 */

namespace JungleTest\SLR;


use Jungle\Parser\Rule;
use Jungle\SLR\Situation;
use Jungle\SLR\SituationSet;
use Jungle\SLR\Table;

class SituationSetTest extends \PHPUnit_Framework_TestCase
{

    public function testAdd()
    {
        $situation = new Situation(new Table(), new Rule());

        $object = new SituationSet();
        $this->assertTrue($object->add($situation));
        $this->assertFalse($object->add($situation));

        $anotherSituation = new Situation(new Table(), new Rule());
        $this->assertTrue($object->add($anotherSituation));
    }

    public function testClosure()
    {
        $ruleA = new Rule('a', ['b', 'c']);
        $ruleB = new Rule('b', ['a']);
        $ruleC = new Rule('c', ['b']);

        $table = new Table();
        $table->addRule($ruleA, 'a');
        $table->addRule($ruleB, 'b');
        $table->addRule($ruleC, 'c');

        $situation = new Situation($table, $ruleA);

        $state = new SituationSet();
        $state->add($situation);

        $result = $state->closure();

        $this->assertInstanceOf('Jungle\SLR\SituationSet', $result);
        $this->assertCount(2, $result);
    }

    public function testGetKey()
    {
        $state = new SituationSet();
        $ruleA = new Rule();
        $ruleA->setId(12);

        $ruleB = new Rule();
        $ruleB->setId(13);

        $state->add(new Situation(new Table(), $ruleA, 1));
        $state->add(new Situation(new Table(), $ruleB, 2));

        $this->assertEquals('12.1|13.2', $state->getKey());
        $this->assertEquals('12.1|13.2', $state->getKey());
    }

    public function testTransition()
    {
        $object = new SituationSet();
        $situation = $this->getMockBuilder('Jungle\SLR\Situation')
            ->setMethods(['next', 'getKey', 'step'])
            ->disableOriginalConstructor()
            ->getMock();

        $situation->expects($this->once())->method('next')->will($this->returnValue('a'));
        $situation->expects($this->once())->method('step')->will(
            $this->returnValue(new Situation(new Table(), new Rule))
        );
        $situation->expects($this->once())->method('getKey')->will($this->returnValue('1.0'));

        $object->add($situation);
        $result = $object->transition('a');
        $this->assertInstanceOf('Jungle\SLR\SituationSet', $result);
        $this->assertCount(1, $result);
    }


}
