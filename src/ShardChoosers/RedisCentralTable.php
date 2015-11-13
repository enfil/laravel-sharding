<?php
namespace Enfil\Sharding\ShardChoosers;

use Enfil\Sharding\Exceptions\ShardingException;

class RedisCentralTable implements ShardChooserInterface
{
    private $connections = [];
    private $relationKey = '';

    public function __construct($connections, $relationKey)
    {
        $this->connections = $connections;
        if (!$relationKey) {
            throw new ShardingException('You should set "relation_key" param in config to use "Central Table" sharding');
        }
        $this->relationKey = $relationKey;
    }

    public function getShardById($id)
    {
        return \Redis::get("$this->relationKey:$id");
    }

    public function chooseShard($id)
    {
        return $this->connections[$id % count($this->connections)];
    }

    public function setRelation($id, $shard)
    {
        return \Redis::set("$this->relationKey:$id",  $shard);
    }
}
