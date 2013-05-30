<?php

include __DIR__ . "/Json.php";

$json = new \Jungle\Example\Json();
var_dump($json->parse('{}'));
var_dump($json->parse('{"x": 1, "y": true}'));
var_dump($json->parse('{"x": [1, "hi", {}]}'));
var_dump($json->parse('{"x": [1, "hi", {}], "b": 76.5}'));
var_dump($json->parse('{"white in string": 1}'));
var_dump($json->parse('{"\"white in string\"": 1}'));
var_dump($json->parse('{"\"white in string\"\\\\": 1}'));
var_dump($json->parse('{"\"white in string\\\\\"\\\\": 1}'));