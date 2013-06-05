<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/31/13 18:02
 */

namespace Jungle\Example\CSS;


class Document
{

    /**
     * @var Block[]
     */
    protected $blocks;

    /**
     * @param Block $block
     */
    public function addBlock(Block $block)
    {
        $this->blocks[] = $block;
    }

    /**
     * Return value of Blocks
     *
     * @return \Jungle\Example\CSS\Block[]
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

}