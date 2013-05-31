<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/31/13 17:19
 */

namespace JungleTest\Example;

include __DIR__ . "/../../../example/json/Json.php";

use Jungle\Example\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Json
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new Json;
    }

    public function testParseSimple()
    {
        $this->assertEquals(array(), $this->object->parse('{}'));
    }

    public function testParseObject()
    {
        $this->assertEquals(array("x" => 1, "y" => true), $this->object->parse('{"x": 1, "y": true}'));
    }

    public function testParseObjectWithArray()
    {
        $this->assertEquals(array("x" => array(1, "hi", array())), $this->object->parse('{"x": [1, "hi", {}]}'));
    }

    public function testParseStrings()
    {
        $this->assertEquals(array("white in string" => 1), $this->object->parse('{"white in string": 1}'));
        $this->assertEquals(array("\"white in string\"" => 1), $this->object->parse('{"\\"white in string\\"": 1}'));
        $this->assertEquals(array("\"white in string" => 1), $this->object->parse('{"\\"white in string": 1}'));
        $this->assertEquals(array("\"white in string\\\"" => 1), $this->object->parse('{"\\"white in string\\\\\"": 1}'));
    }

}
