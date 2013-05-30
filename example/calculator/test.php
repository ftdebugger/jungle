<?php

/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/30/13 18:14
 */

include __DIR__ . "/Calculator.php";


function calculate($expression, $expect)
{
    echo 'Calculate expression: ' . $expression . ' = ';
    $calculator = new \Jungle\Example\Calculator();
    $result = $calculator->parse($expression);
    echo $result . PHP_EOL;

    if ($result != $expect) {
        echo "Expected " . $expect . " output " . $result . PHP_EOL;
        exit(1);
    }

}

$tests = array(
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

foreach ($tests as $test) {
    calculate($test[0], $test[1]);
}