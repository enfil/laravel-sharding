<?php
namespace Enfil\Sharding\ShardChoosers;

use Enfil\Sharding\Exceptions\ShardingException;

class ServerRanges implements ShardChooserInterface
{
    private $connections = [];

    public function __construct($connections, $relationKey = null)
    {
        $this->connections = $connections;
    }

    public function getShardById($id)
    {
        foreach ($this->connections as $shard => $range) {
            if ($id >= $range[0] && $id <= $range[1]) {
                return $shard;
            }
        }
        throw new ShardingException('Your must to set up range for this id!');
    }

    public function chooseShard($id)
    {
        return $this->getShardById($id);
    }


}
