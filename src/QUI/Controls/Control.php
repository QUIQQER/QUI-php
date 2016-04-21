<?php

/**
 * This file contains \QUI\Controls\Control
 */

namespace QUI\Controls;

use QUI;

/**
 * Class Control
 *
 * @package QUI\Controls
 */
abstract class Control extends QUI\QDOM implements QUI\Interfaces\Control
{
    /**
     * control styles
     *
     * @var array
     */
    protected $styles = array();

    /**
     * css file list
     *
     * @var array
     */
    protected $cssFiles = array();

    /**
     * @var QUI\Events\Event
     */
    protected $Events;

    /**
     * Control constructor.
     */
    public function __construct()
    {
        $this->Events = new QUI\Events\Event();

        QUI\Controls\Handler::getInstance()->register($this);
    }

    /**
     * Events
     */

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Interfaces\Events::addEvent()
     *
     * @param string $event - The type of event (e.g. 'complete').
     * @param callback $fn - The function to execute.
     */
    public function addEvent($event, $fn)
    {
        $this->Events->addEvent($event, $fn);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Interfaces\Events::addEvents()
     *
     * @param array $events
     */
    public function addEvents(array $events)
    {
        $this->Events->addEvents($events);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Interfaces\Events::removeEvent()
     *
     * @param string $event - The type of event (e.g. 'complete').
     * @param callback|boolean $fn - (optional) The function to remove.
     */
    public function removeEvent($event, $fn = false)
    {
        $this->Events->removeEvent($event, $fn);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Interfaces\Events::removeEvents()
     *
     * @param array $events - (optional) If not passed removes all events of all types.
     */
    public function removeEvents(array $events)
    {
        $this->Events->removeEvents($events);
    }

    /**
     * CSS
     */

    /**
     * @return array
     */
    public function getCSSFiles()
    {
        return $this->cssFiles;
    }

    /**
     * Add a css file
     *
     * @param $file
     */
    public function addCSSFile($file)
    {
        if (file_exists($file)) {
            $this->cssFiles[] = $file;
        }
    }

    /**
     * Set control style
     *
     * @param string $name
     * @param string $value
     */
    public function setStyle($name, $value)
    {
        $this->styles[$name] = $value;
    }

    /**
     * Set multiple control styles
     *
     * @param array $styles
     */
    public function setStyles($styles = array())
    {
        foreach ($styles as $key => $value) {
            $this->setStyle($key, $value);
        }
    }

    /**
     * Return the control styles
     *
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * Render
     */

    /**
     * Create the html
     *
     * @return string
     */
    public function create()
    {
        $this->Events->fireEvent('create', array($this));

        $cssFiles = $this->getCSSFiles();

        if (!empty($cssFiles)) {

        }

        if (method_exists($this, 'onCreate')) {
            return $this->onCreate();
        }

        return '';
    }
}
