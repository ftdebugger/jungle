<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/23/13 13:54
 */

namespace Jungle\Code\Statement;


use Jungle\Code\AbstractGenerator;

class FunctionStatement extends AbstractGenerator
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param string $name
     * @param array $params
     */
    public function __construct($name = null, $params = null)
    {
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->getName() . '(' . implode(", ", $this->getParams()) . ')';
    }

    /**
     * Set value of Name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Return value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value of Params
     *
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * Return value of Params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }


}