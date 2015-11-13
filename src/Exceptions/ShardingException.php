<?php
namespace Enfil\Sharding\Exceptions;

class ShardingException extends \Exception
{
    /**
     * ShardingException constructor.
     * @param string $message
     */
    public function __construct($message = 'An error occurred')
    {
        parent::__construct($message);
    }

}