<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 13:58
 */

namespace Jungle\Code\Statement;


use Jungle\Code\AbstractGenerator;

class ScalarStatement extends AbstractGenerator
{

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function generate()
    {
        return var_export($this->value, true);
    }


}