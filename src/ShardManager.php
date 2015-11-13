<?php
namespace Enfil\Sharding;

/**
 * Class ShardManager
 * @package Enfil\Sharding
 */
class ShardManager
{
    /**
     * object
     */
    private $shardChooser;
    private $idGenerator;
    private $mapManger;

    public function __construct(MapManager $mapManger)
    {
        $this->mapManger = $mapManger;
    }

    public function setService($name)
    {
        $this->mapManger->setService($name);
        $this->shardChooser = $this->mapManger->getShardChooser();
        $this->idGenerator = $this->mapManger->getidGenerator();
    }

    public function getShardById($id)
    {
        return $this->shardChooser->getShardById($id);
    }

    public function getIdsFromShard($firsId, $lastId, $shard)
    {
        return $this->shardChooser->getIdsFromShard($firsId, $lastId, $shard);
    }

    public function getLastId()
    {
        return $this->idGenerator->getLastId();
    }

    public function getNextId()
    {
        return $this->idGenerator->getNextId();
    }

    public function increment()
    {
        return $this->idGenerator->increment();
    }

    public function chooseShard($id)
    {
        return $this->shardChooser->chooseShard($id);
    }

    public function setRelation($id, $shard)
    {
        return $this->shardChooser->setRelation($id, $shard);
    }
}