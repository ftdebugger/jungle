<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/18/13 17:01
 */

namespace Jungle\Stream;


abstract class AbstractStream
{

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var int
     */
    protected $length = 0;

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return ($this->getPosition() >= $this->getLength());
    }

    /**
     * @return string
     */
    public function getString()
    {
        return mb_substr($this->getContent(), $this->getPosition());
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function getSubstring($length)
    {
        return mb_substr($this->getContent(), $this->getPosition(), $length);
    }

    /**
     * @param int $string
     *
     * @return bool
     */
    public function compareString($string)
    {
        return $this->getSubstring(mb_strlen($string, 'utf-8')) == $string;
    }

    /**
     * @param string $string
     */
    public function skipString($string)
    {
        $this->position += mb_strlen($string, 'utf-8');
    }

    /**
     * Set value of Content
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->length = mb_strlen($content, 'utf-8');
    }

    /**
     * Return value of Content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Return value of Length
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Return value of Position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }


}
