<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/28/13 16:25
 */

namespace JungleTest\SLR;


use Jungle\Parser\Rule;
use Jungle\SLR\Situation;
use Jungle\SLR\Table;

class SituationTest extends \PHPUnit_Framework_TestCase
{

    public function testGetKey()
    {
        $rule = new Rule();
        $rule->setId(1);

        $object = new Situation(new Table(), $rule, 2);
        $this->assertEquals('1.2', $object->getKey());
    }

    public function testHasNext()
    {
        $rule = new Rule();

        $object = new Situation(new Table(), $rule);
        $this->assertFalse($object->hasNext());

        $rule->setRight([new Rule()]);
        $this->assertTrue($object->hasNext());
    }

    public function testNext()
    {
        $rule = new Rule();

        $object = new Situation(new Table(), $rule);
        $this->assertFalse($object->next());

        $nextRule = new Rule();

        $rule->setRight([$nextRule]);
        $this->assertSame($nextRule, $object->next());
    }

}
