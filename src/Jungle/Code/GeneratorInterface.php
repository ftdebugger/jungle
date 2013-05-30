<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 12:35
 */

namespace Jungle\Code;

interface GeneratorInterface extends \Zend\Code\Generator\GeneratorInterface
{

    /**
     * @return string
     */
    public function __toString();

}