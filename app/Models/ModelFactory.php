<?php namespace App\Models;

/**
 * Class ModelFactory
 *
 * Simmple factory class to handle singletons for models
 * to improved on performance and memory usage.
 *
 * @package App\Models
 */
class ModelFactory
{
    /**
     * @var array
     */
    protected $cache = [];

    /**
     * Returns a cached instance of the model
     *
     * @param string $class
     * @param bool   $shared
     */
    public function factory(string $class, bool $shared = true)
    {
        if ($shared && ! array_key_exists($class, $this->cache)) {
            $this->cache[$class] = new $class();
        }

        return $this->cache[$class];
    }
}
