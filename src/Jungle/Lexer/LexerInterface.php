<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:19
 */

namespace Jungle\Lexer;


use Jungle\Code\GeneratorInterface;

interface LexerInterface
{

    /**
     * @param \Jungle\Code\GeneratorInterface $input
     *
     * @return string
     */
    public function getGenerator(GeneratorInterface $input);

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * Set value of Weight
     *
     * @param int $weight
     */
    public function setWeight($weight);

}