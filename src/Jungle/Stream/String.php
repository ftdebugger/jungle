<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:00
 */

namespace Jungle\Stream;


class String extends AbstractStream
{

    /**
     * @param $string
     */
    public function __construct($string)
    {
        $this->setContent($string);
    }

}