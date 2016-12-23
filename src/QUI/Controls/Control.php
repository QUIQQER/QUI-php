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
     * css classes
     *
     * @var array
     */
    protected $cssClasses = array();

    /**
     * JavaScript QUI Require Module name
     * @var string
     */
    protected $module = '';

    /**
     * @var QUI\Events\Event
     */
    protected $Events;

    /**
     * Control constructor.
     *
     * @param array $params
     */
    public function __construct($params = array())
    {
        $this->Events = new QUI\Events\Event();

        if (isset($params['styles'])) {
            $this->setStyles($params['styles']);
            unset($params['styles']);
        }

        if (isset($params['class'])) {
            $this->addCSSClass($params['class']);
            unset($params['class']);
        }

        if (isset($params['events'])) {
            $this->addEvents($params['events']);
            unset($params['events']);
        }

        $this->setAttributes($params);
    }

    /**
     * Set the javascript qui module class
     *
     * @param string $module
     */
    protected function setModule($module)
    {
        $this->module = $module;
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
     * Add a css class
     *
     * @param string $cssClass
     */
    public function addCSSClass($cssClass)
    {
        if (!is_string($cssClass)) {
            return;
        }

        if (empty($cssClass)) {
            return;
        }

        $classes = preg_replace('/[^_a-zA-Z0-9-]/', ' ', $cssClass);
        $classes = explode(' ', $classes);

        foreach ($classes as $cssClass) {
            if (!isset($this->cssClasses[$cssClass])) {
                $this->cssClasses[$cssClass] = true;
            }
        }
    }

    /**
     * Return all css classes
     *
     * @return string
     */
    public function getCSSClasses()
    {
        return $this->cssClasses;
    }

    /**
     * @param string|integer|float $val
     *
     * @return string
     */
    protected function parseCSSValue($val)
    {
        $val = trim($val);

        if (empty($val)) {
            return '';
        }

        if (is_numeric($val)) {
            return (string)$val . 'px';
        }

        if (strpos($val, 'calc(') !== false) {
            return (string)$val;
        }

        $units = array(
            'px',
            'cm',
            'mm',
            'mozmm',
            'in',
            'pt',
            'pc',
            'vh',
            'vw',
            'vm',
            'vmin',
            'vmax',
            'rem',
            '%',
            'em',
            'ex',
            'ch',
            'fr',
            'deg',
            'grad',
            'rad',
            's',
            'ms',
            'turns',
            'Hz',
            'kHz'
        );

        $no   = (int)$val;
        $unit = str_replace($no, '', $val);

        if (in_array($unit, $units)) {
            return $no . $unit;
        }

        if (!empty($no) && empty($unit)) {
            return $no . 'px';
        }

        return '';
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

        $render   = '';
        $cssFiles = $this->getCSSFiles();
        $quiPath  = QUI\Controls\Handler::getInstance()->getConfig('QUI_PATH');

        if (!empty($cssFiles)) {
            foreach ($cssFiles as $cssFile) {
                $relative = str_replace($quiPath, '', $cssFile);

                $render .= '<style data-file="' . $relative . '" data-qui-module="' . $this->module . '">';
                $render .= file_get_contents($cssFile);
                $render .= '</style>';
            }
        }

        if (method_exists($this, 'onCreate')) {
            $render .= $this->onCreate();
        }

        return $render;
    }
}
