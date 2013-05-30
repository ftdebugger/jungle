<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/22/13 18:37
 */

namespace Jungle\AST;


class Node implements NodeInterface
{

    /**
     * @var NodeInterface[]
     */
    protected $nodes;

    /**
     * Set value of Nodes
     *
     * @param \Jungle\AST\NodeInterface[] $nodes
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;
    }

    /**
     * Return value of Nodes
     *
     * @return \Jungle\AST\NodeInterface[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param NodeInterface $node
     */
    public function addNode(NodeInterface $node)
    {
        $this->nodes[] = $node;
    }

}