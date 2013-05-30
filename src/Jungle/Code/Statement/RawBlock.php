<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 14:14
 */

namespace Jungle\Code\Statement;


use Jungle\Code\AbstractGenerator;

class RawBlock extends AbstractGenerator
{

    /**
     * @var string
     */
    protected $raw = '';

    /**
     * @param string $raw
     */
    public function __construct($raw = null)
    {
        $this->raw = $raw;
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->getRaw();
    }

    /**
     * Set value of Raw
     *
     * @param string $raw
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

    /**
     * Return value of Raw
     *
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

}