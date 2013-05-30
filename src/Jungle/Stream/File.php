<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 16:49
 */

namespace Jungle\Stream;


use Jungle\Exception\RuntimeException;

class File extends AbstractStream
{

    /**
     * @param string $filename
     *
     * @throws \Jungle\Exception\RuntimeException
     */
    public function __construct($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new RuntimeException('Cannot open file "' . $filename . '"');
        }

        $this->setContent(file_get_contents($filename));
    }


}