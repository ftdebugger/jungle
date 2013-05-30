<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 18:13
 */

namespace Jungle\AST;


use Jungle\Token\Token;

class ClassNode
{

    /**
     * @var Token
     */
    protected $name;

    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }


}