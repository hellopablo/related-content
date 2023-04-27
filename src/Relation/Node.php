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
    protected string $type;

    /** @var mixed */
    protected mixed $value;

    // --------------------------------------------------------------------------

    /**
     * Node constructor.
     *
     * @param string $type  The type of node
     * @param mixed  $value The node's value
     */
    public function __construct(string $type, mixed $value)
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
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
