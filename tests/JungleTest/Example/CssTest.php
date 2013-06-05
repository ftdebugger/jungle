<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/31/13 17:44
 */

namespace JungleTest\Example;


use Jungle\Example\CSS\Document;
use Jungle\Example\Css\Parser;

include __DIR__ . "/../../../example/css/Css.php";

class CssTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $object = new Parser();

        /** @var Document $result */
        $result = $object->parse('a, .abc, #h0, #f00 a.color {
            color: #fff;
            padding: 1px 0 25% .04;
        }');

        $this->assertInstanceOf('Jungle\Example\CSS\Document', $result);
        $this->assertCount(1, $result->getBlocks());

        $block = $result->getBlocks()[0];
        $this->assertCount(4, $block->getSelectors());
        $this->assertCount(2, $block->getRules());

        // rules
        $this->assertEquals('#fff', $block->getRule('color')->getValue());
        $this->assertEquals(['1px', '0', '25%', '.04'], $block->getRule('padding')->getValue());

        // selectors
        $selectors = $block->getSelectors();
        $this->assertEquals('a', $selectors[0]->asString());
        $this->assertEquals('.abc', $selectors[1]->asString());
        $this->assertEquals('#h0', $selectors[2]->asString());
        $this->assertEquals('#f00 a.color ', $selectors[3]->asString());
    }

    public function testParsePaddingMargin()
    {
        $object = new Parser();

        /** @var Document $result */
        $result = $object->parse('a{
            padding: 1px;
            margin: 0 auto;
        }');

        $this->assertInstanceOf('Jungle\Example\CSS\Document', $result);
        $this->assertCount(1, $result->getBlocks());

        $block = $result->getBlocks()[0];

        // rules
        $this->assertEquals(['1px'], $block->getRule('padding')->getValue());
        $this->assertEquals(['0', 'auto'], $block->getRule('margin')->getValue());
    }

}
