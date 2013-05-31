<?php

namespace JungleTest\Example;

use Jungle\Example\Calculator;

include __DIR__ . "/../../../example/calculator/Calculator.php";

/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/31/13 17:14
 */

class CalculatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider parseDataProvider
     */
    public function testParse($expression, $expect)
    {
        $calculator = new Calculator();
        $result = $calculator->parse($expression);
        $this->assertEquals($expect, $result);
    }

    public function parseDataProvider()
    {
        return array(
            array('1', 1),
            array('1+1', 2),
            array('2*3', 6),
            array('6/2', 3),
            array('2^10', 1024),
            array('(1+1)^10', 1024),
            array('1+2^10', 1025),
            array('2*2^10', 2048),
            array('(1+1)^10+1', 1025),
            array('(1+1)^10*2', 2048),
            array('(1+1)^(10+1)', 2048),
            array('1+2*3', 7),
            array('1+2*(17-3)/7', 5),
            array('1 + 2 * ( 17 - 3 ) / 7', 5)
        );
    }

}