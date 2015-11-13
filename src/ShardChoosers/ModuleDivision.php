<?php
namespace Enfil\Sharding\ShardChoosers;


class ModuleDivision implements ShardChooserInterface
{
    private $connections = [];

    public function __construct($connections, $relationKey = null)
    {
        $this->connections = $connections;
    }

    public function getShardById($id)
    {
        return $this->connections[$id % count($this->connections)];
    }

    public function chooseShard($id)
    {
        return $this->getShardById($id);
    }

}
