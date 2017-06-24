<?php
/**
 * Created by PhpStorm.
 * User: Muhannad Shelleh <muhannad.shelleh@live.com>
 * Date: 6/24/17
 * Time: 2:58 PM
 */

namespace ItvisionSy\Tree;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use JsonSerializable;

class Tree implements IteratorAggregate, JsonSerializable, ArrayAccess, Countable
{

    /** @var TreeNode[] */
    protected $roots = [];

    /** @var TreeNode[] */
    protected $nodes = [];

    /**
     * @param $id
     * @param $data
     * @param null $parentId
     * @return $this
     * @throws Exception
     * @internal param TreeNode $node
     */
    public function insert($id, $data, $parentId = null)
    {
        $node = new TreeNode($id, $data);
        if ($parentId && !$this->offsetExists($parentId)) {
            throw new Exception("Parent node does not exist");
        } elseif ($parentId) {
            $parentNode = $this->offsetGet($parentId);
            $node->setParent($parentNode);
            $parentNode->addChild($node);
        } else {
            $parentNode = null;
            $this->roots[] = $node;
        }
        $this->nodes[$node->getId()] = $node;
        return $this;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->roots);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function (TreeNode $node) {
            return $node->toArray();
        }, $this->roots);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->nodes);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return TreeNode
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->nodes[$offset];
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @throws Exception
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception("Use the insert function");
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @throws Exception
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        throw new Exception("Not implemented");
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return array.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->nodes);
    }

    /**
     * @return TreeNode[]
     */
    public function getRoots()
    {
        return $this->roots;
    }

    /**
     * @return TreeNode[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

}
