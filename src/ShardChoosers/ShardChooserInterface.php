<?php
namespace Enfil\Sharding\ShardChoosers;

interface ShardChooserInterface
{
    public function getShardById($id);

    public function chooseShard($id);
}
