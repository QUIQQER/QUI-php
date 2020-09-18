<?php

/**
 * This file contains \QUI\Controls\Handler
 */

namespace QUI\Controls;

use QUI;

/**
 * Class Control
 */
class Handler
{
    /**
     * @var null|Handler
     */
    private static $Instance = null;

    /**
     * QUI configuration
     *
     * @var array
     */
    protected $config = [];

    /**
     * list of css files
     *
     * @var array
     */
    protected $cssFiles = [];

    /**
     * Handler constructor.
     *
     * @param array $config - Configuration - QUI_PATH
     */
    public function __construct($config = [])
    {
        $packages = dirname(dirname(dirname(dirname(dirname(__FILE__)))));

        // default config
        $this->config = [
            'QUI_PATH' => $packages.'/qui/'
        ];

        $this->setConfig($config);
    }

    /**
     * create instance
     *
     * @return Handler
     */
    public static function getInstance()
    {
        if (is_null(self::$Instance)) {
            self::$Instance = new self();
        }

        return self::$Instance;
    }

    /**
     * Set config entries
     *
     * @param array|string $config
     * @param bool|mixed $value - optional
     */
    public function setConfig($config = [], $value = false)
    {
        if (is_array($config)) {
            foreach ($config as $name => $value) {
                $this->config[$name] = $value;
            }

            return;
        }

        if (is_string($config)) {
            $this->config[$config] = $value;
        }
    }

    /**
     * Return the config or a config entry
     *
     * @param bool $name
     * @return array|string|null|mixed
     */
    public function getConfig($name = false)
    {
        if ($name === false) {
            return $this->config;
        }

        if (isset($this->config[$name])) {
            return $this->config[$name];
        }

        return null;
    }
}
