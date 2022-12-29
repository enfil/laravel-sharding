# laravel-sharding

################################################
#                **LEGACY!!!**                 #
#           CLOSED AND NOT SUPPORTED           #
################################################

## Installation

#### Download package  
`composer require enfil/sharding`

#### Add to Providers 
Add `Enfil\Sharding\ShardingServiceProvider::class,` to the `providers` array in `/config/app.php`.

#### Add to Aliases
Add `'ShardManager'  => \Enfil\Sharding\Facades\ShardManager::class,` to the `alias` list in `/config/app.php`.

#### Publish config
`php artisan vendor:publish --provider="Enfil\Sharding\ShardingServiceProvider" --tag="config" --force`

## Configuration

You can configurate sharding for all your services in the `sharding.php` config file located in the `config` directory.

## Usage

First of all you should set your service:

`\ShardManager::setService('auth');`

#### Adding data
When you're inserting any element into your database you should generate unique ID for it.
You can get next id using:

`$id = \ShardManager::getNextId();`

Than you can choose shard (database connection) using:

`$shard = \ShardManager::getShardById($id);`

Now you can insert your data to current shard:

```
\DB::connection($shard)->table('t')->insert(
    [...]
);
```

After inserting you should increment id-generator:

`\ShardManager::increment();`

#### Selecting data
To select your data by id you should get a shard:

`$shard = \ShardManager::getShardById($id);`

Than you can get data from current shard:

`DB::connection($shard)->table('t')->select(...);`
