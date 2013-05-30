<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/30/13 15:23
 */

namespace JungleTest\SLR;


use Jungle\SLR\Table;

class TableTest extends \PHPUnit_Framework_TestCase
{

    public function testGetReduce()
    {
        $object = new Table();
        $this->assertEquals($object->getReduce('abc'), $object->getReduce('abc'));
        $this->assertEquals($object->getReduce(' abc'), $object->getReduce('abc '));
        $this->assertNotEquals($object->getReduce('abc'), $object->getReduce('abcd'));
    }

}
