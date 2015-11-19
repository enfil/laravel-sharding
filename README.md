#laravel-sharding

##Installation

####Download package  
composer require enfil/sharding

####Add to Prividers 
Add _Enfil\Sharding\ShardingServiceProvider::class,_ to _providers_ list in /config/app.php.

####Add to Aliases
Add _'ShardManager'  => \Enfil\Sharding\Facades\ShardManager::class,_ to _alias_ list in /config/app.php.

####Publish config
_php artisan vendor:publish --provider="Enfil\Sharding\ShardingServiceProvider" --tag="config" --force_

##Configuration

You can configurate sharding for all your services in _sharding.php_ config file

##Usage

First of all you should set your service:

_\ShardManager::setService('auth');_

####Adding data
When you're inserting any element into your database you should generate unique ID for it.
You can get next id using:

_$id = \ShardManager::getNextId();_

Than you can choose shard (database connection) using:

_$shard = \ShardManager::getShardById($id);_

Now you can insert your data to current shard:

\DB::connection($shard)->table('t')->insert(
    [...]
);

After inserting you should increment id-generator:

_\ShardManager::increment();_

####Selecting data
To select your data by id you should get a shard:

_$shard = \ShardManager::getShardById($id);_

Than you can get data from current shard:

\DB::connection($shard)->table('t')->select(...);
