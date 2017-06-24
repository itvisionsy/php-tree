<?php
/**
 * Created by PhpStorm.
 * User: Muhannad Shelleh <muhannad.shelleh@live.com>
 * Date: 6/24/17
 * Time: 3:28 PM
 */

use ItvisionSy\Tree\Tree;
use PHPUnit\Framework\TestCase;

class TreeTest extends TestCase
{

    public function testRandom()
    {
        $tree = $this->randomTree();
        $this->assertEquals(10, count($tree->getRoots()));
        $this->assertTrue($tree->offsetExists(50));
        $this->assertFalse($tree->offsetExists(101));
        $this->assertEquals(50, $tree->offsetGet(50)->getData());
        $this->assertTrue($tree->offsetGet(50)->getParent()->getId() < 50);

    }

    public function testIterator()
    {
        $count = 0;
        $tree = $this->randomTree();
        foreach ($tree as $node) {
            $count++;
        }
        $this->assertEquals(10, $count);
        $this->assertTrue(is_array($tree->toArray()));
    }

    private function randomTree()
    {
        $tree = new Tree();
        for ($i = 1; $i <= 10; $i++) {
            $tree->insert($i, $i);
        }
        for ($i = 11; $i <= 100; $i++) {
            $parent = rand(1, $i - 1);
            $tree->insert($i, $i, $parent);
        }
        return $tree;
    }

}
