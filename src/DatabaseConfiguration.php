<?php

namespace SimpleDataBaseOrm;

use InvalidArgumentException;

class DatabaseConfiguration
{
    /**
     * Minimum connection params
     *
     * @var array
     */
    private $connectionRequirements = [
        'driver',
        'hostname',
        'database'
    ];

    /**
     * Keep database configuration
     *
     * @var array
     */
    private $configuration = [];

    /**
     * DatabaseConfiguration constructor.
     * @param string|array $config
     */
    public function __construct($config)
    {
        $this->readConfig($config);

        $this->validateConfig();
    }

    /**
     * read configuration file
     *
     * @param $config
     * @return mixed
     */
    private function readConfig($config)
    {
        if (is_file($config))
        {
            return $this->configuration = require $config;
        }

        if (is_array($config) )
        {
            $this->configuration = $config;
        }

        throw new InvalidArgumentException("No Database configurations were provided");
    }

    /**
     * Validate configuration file
     */
    private function validateConfig()
    {
        if ( empty($this->configuration['connections']) )
        {
            throw new InvalidArgumentException("No connection defined. At least one is connection is necessary");
        }

        if ( empty($this->configuration['default']) || empty($this->configuration['connections']['default']))
        {
            throw new InvalidArgumentException("No default configurations to Database!");
        }

        foreach ($this->configuration['connections'] as $name => $connection)
        {
            if ( empty(array_diff($this->connectionRequirements, array_keys($connection))) )
            {
                continue;
            }

            throw new InvalidArgumentException("No default configurations to Database!");
        }
    }

    /**
     * Parse array by . notation keys
     *
     * @param $key
     * @param string $delimiter
     * @return mixed|null
     */
    private function parseKey($key, $delimiter = '.')
    {
        $data = $this->configuration;

        $keys = explode($delimiter, $key);

        while (!empty($keys))
        {
            $key = array_shift($keys);

            if (!isset($this->configuration[$key]))
            {
                return null;
            }

            $data = $data[$key];
        }

        return $data;
    }

    /**
     * Get configuration value by . notation key
     *
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->parseKey($key);
    }
}