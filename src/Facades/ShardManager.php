<?php
namespace Enfil\Sharding\Facades;

use Illuminate\Support\Facades\Facade;

class ShardManager extends Facade {
    protected static function getFacadeAccessor() { return 'enfil.shardmanager'; } // most likely you want MyClass here
}