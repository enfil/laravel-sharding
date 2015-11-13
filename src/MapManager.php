<?php
namespace Enfil\Sharding;

use Enfil\Sharding\Exceptions\ShardingException;
use Enfil\Sharding\ShardChoosers\ShardChooserInterface;
use Enfil\Sharding\IdGenerators\IdGeneratorInterface;

/**
 * Class MapManager
 * @package Enfil\Sharding
 */
class MapManager
{
    /**
     * Full config map
     * @var array $map
     */
    private $map = [];
    /**
     * Connections list for current service
     * @var array $currentConnections
     */
    private $currentConnections = [];
    /**
     * Array of object per services
     * Example
     * [
     *  'auth' => [
     *      'shard_chooser' => 'Enfil\Sharding\ShardChoosers\ModuleDivision',
     *      'id_generator' => 'Enfil\Sharding\IdGenerators\RedisSequence'
     *  ],
     * ]
     * @var array $container
     */
    private $container = [];
    /**
     * Current service name
     * @var string $name
     */
    private $name;

    /**
     * MapManager constructor.
     * @param $map - config
     */
    public function __construct($map)
    {
        $this->map = $map;
    }

    public function setService($name)
    {
        $this->name = $name;
        if (!isset($this->map[$name]['connections'])) {
            throw new ShardingException('Connections are not configured for ' . $name . ' service');
        }
        $this->currentConnections = $this->map[$name]['connections'];

        if (!isset($this->map[$name]['shard_chooser'])) {
            throw new ShardingException('Shard chooser are not configured for ' . $name . ' service');
        }

        $chooserClass = $this->map[$name]['shard_chooser'];
        $relationKey = (isset($this->map[$name]['relation_key']) ? $this->map[$name]['relation_key'] : null);
        $chooser = new $chooserClass($this->currentConnections, $relationKey);
        if (!$chooser instanceof ShardChooserInterface) {
            throw new ShardingException('Shard chooser must be instanceof ShardChooserInterface');
        }

        if (!isset($this->container[$name]['shard_chooser'])) {
            $this->container[$name]['shard_chooser'] = $chooser;
        }

        if (!isset($this->map[$name]['id_generator'])) {
            throw new ShardingException('Id generator are not configured for ' . $name . ' service');
        }

        $generatorClass = $this->map[$name]['id_generator'];
        $sequenceKey = $this->map[$name]['sequence_key'];
        $generator = new $generatorClass($sequenceKey);
        if (!$generator instanceof IdGeneratorInterface) {
            throw new ShardingException('Id generator must be instanceof IdGeneratorInterface');
        }
        if (!isset($this->container[$name]['id_generator'])) {
            $this->container[$name]['id_generator'] = $generator;
        }
    }

    public function getShardChooser()
    {
        return $this->container[$this->name]['shard_chooser'];
    }

    public function getIdGenerator()
    {
        return $this->container[$this->name]['id_generator'];
    }
}
