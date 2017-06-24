<?php
/**
 * Created by PhpStorm.
 * User: Muhannad Shelleh <muhannad.shelleh@live.com>
 * Date: 6/24/17
 * Time: 4:24 PM
 */

namespace ItvisionSy\Tree;


interface ITreeNode
{

    public function getId();

    public function setId($value);

    public function getChildren();

    public function addChild(ITreeNode &$node);

    public function getParent();

    public function setParent(ITreeNode &$parent);

    public function getData();

    public function setData($data);

}