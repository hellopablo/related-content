<?php

namespace HelloPablo\RelatedContent\Relation;

use HelloPablo\RelatedContent\Interfaces;

/**
 * Class Node
 *
 * @package HelloPablo\RelatedContent\Relation
 */
class Node implements Interfaces\Relation
{
    /** @var string */
    protected $type;

    /** @var mixed */
    protected $value;

    // --------------------------------------------------------------------------

    /**
     * Node constructor.
     *
     * @param string $type  The type of node
     * @param mixed  $value The node's value
     */
    public function __construct(string $type, $value)
    {
        $this->type  = $type;
        $this->value = $value;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the type of node
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the node's value
     *
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }
}
