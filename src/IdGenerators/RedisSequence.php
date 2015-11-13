<?php
namespace Enfil\Sharding\IdGenerators;


class RedisSequence implements IdGeneratorInterface
{
    private $sequenceKey;

    public function __construct($sequenceKey)
    {
        $this->sequenceKey = $sequenceKey;
    }

    public function getNextId()
    {
        return (int)\Redis::get($this->sequenceKey) + 1;
    }

    public function getLastId()
    {
        return (int)\Redis::get($this->sequenceKey);
    }

    public function setLastId($id)
    {
        return \Redis::set($this->sequenceKey, $id);
    }

    public function increment()
    {
        return \Redis::incr($this->sequenceKey);
    }
}