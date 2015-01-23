<?php
/**
 * Copyright (C) 2015 David Young
 * 
 * Defines a response node
 */
namespace RDev\Console\Responses\Compilers\Nodes;

abstract class Node
{
    /** @var mixed|null The value of the node */
    protected $value = null;
    /** @var Node|null The parent node */
    protected $parent = null;
    /** @var Node[] The child nodes */
    protected $children = [];

    /**
     * @param mixed $value The value of the node
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * Gets whether or not this is a tag node
     *
     * @return bool True if this is a tag node, otherwise false
     */
    abstract public function isTag();

    /**
     * Adds a child to this node
     *
     * @param Node $node The child to add
     */
    public function addChild(Node $node)
    {
        $node->setParent($this);
        $this->children[] = $node;
    }

    /**
     * Gets the list of children of this node
     *
     * @return Node[] The list of children
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Gets the parent node
     *
     * @return null|Node The parent node if there is one, otherwise null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Gets the value of this node
     *
     * @return mixed|null The value of this node if there is one, otherwise null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets whether or not this node is a leaf
     *
     * @return bool True if this is a leaf, otherwise false
     */
    public function isLeaf()
    {
        return count($this->children) == 0;
    }

    /**
     * Gets whether or not this node is the root
     *
     * @return bool True if this is a root node, otherwise false
     */
    public function isRoot()
    {
        return $this->parent == null;
    }

    /**
     * @param null|Node $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
}