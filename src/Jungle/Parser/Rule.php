<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 17:30
 */

namespace Jungle\Parser;


class Rule
{

    /**
     * @var int
     */
    private static $nextId = 0;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $left;

    /**
     * @var string[]
     */
    protected $right = array();

    /**
     * @var string
     */
    protected $callback;

    /**
     * @param $left
     * @param $right
     */
    public function __construct($left = null, $right = [])
    {
        $this->id = self::$nextId++;

        $this->setLeft($left);
        $this->setRight($right);
    }

    /**
     * @return int
     */
    public function getRightCount()
    {
        return count($this->getRight());
    }


    /**
     * Set value of Id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Return value of Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value of Left
     *
     * @param string $left
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * Return value of Left
     *
     * @return string
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set value of Right
     *
     * @param string[] $right
     */
    public function setRight($right)
    {
        $this->right = $right;
    }

    /**
     * Return value of Right
     *
     * @return string[]
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param int $marker
     *
     * @return bool|Rule
     */
    public function getByMarker($marker)
    {
        $right = array_values($this->getRight());
        if (isset($right[$marker])) {
            return $right[$marker];
        } else {
            return false;
        }
    }

    /**
     * Set value of Callback
     *
     * @param string $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    /**
     * Return value of Callback
     *
     * @return string
     */
    public function getCallback()
    {
        return $this->callback;
    }


}