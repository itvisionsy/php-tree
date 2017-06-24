<?php
/**
 * Created by PhpStorm.
 * User: Muhannad Shelleh <muhannad.shelleh@live.com>
 * Date: 6/24/17
 * Time: 2:59 PM
 */

namespace ItvisionSy\Tree;


class TreeNode implements \ArrayAccess, \IteratorAggregate, \JsonSerializable
{
    /** @var TreeNode[] */
    protected $children = [];

    protected $id;

    protected $data;

    /**
     * TreeNode constructor.
     * @param $id
     * @param $data
     */
    public function __construct($id, $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return TreeNode[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param TreeNode $node
     */
    public function addChild(TreeNode &$node)
    {
        $this->children[] = $node;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return ['data' => $this->data, 'children' => array_map(function (TreeNode $node) {
            return $node->toArray();
        }, $this->getChildren())];
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
        return new \ArrayIterator($this->children);
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
        return array_key_exists($offset, $this->children);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->children[$offset];
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
     * @throws \Exception
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception("Not allowed. Use addChild method instead");
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @throws \Exception
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        throw new \Exception("Not implemented");
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return json_encode($this->toArray());
    }
}