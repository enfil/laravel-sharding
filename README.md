#laravel-sharding

##Installation

###Download package  
composer require enfil/sharding

###Add to Prividers 
Add _Enfil\Sharding\ShardingServiceProvider::class,_ to _providers_ list in /config/app.php.

###Add to Aliases
Add _'ShardManager'  => \Enfil\Sharding\Facades\ShardManager::class,_ to _alias_ list in /config/app.php.

###Publish config
_php artisan vendor:publish --provider="Enfil\Sharding\ShardingServiceProvider" --tag="config" --force_
