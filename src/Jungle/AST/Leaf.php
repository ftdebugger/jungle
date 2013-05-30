<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/22/13 18:27
 */

namespace Jungle\AST;


use Jungle\Token\Token;

class Leaf implements NodeInterface
{

    /**
     * @var Token
     */
    protected $token;

    /**
     * @param Token $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }


}