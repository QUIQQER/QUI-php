<?php

/**
 * This file contains the \QUI\Controls\Toolbar\Tab
 */

namespace QUI\Controls\Toolbar;

use QUI;

/**
 * A Toolbar Tab
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.toolbar
 */

class Tab extends QUI\QDOM
{
    /**
     * The Parent object
     *
     * @var \QUI\Controls\Control
     */
    private $_parent;

    /**
     * Constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->setAttributes($attributes);
    }

    /**
     * Set the Parent
     *
     * @param \QUI\Controls\Toolbar\Bar $Parent
     */
    public function addParent(QUI\Controls\Toolbar\Bar $Parent)
    {
        $this->_parent = $Parent;
    }

    /**
     * Get the name attribute from the control
     *
     * @return String
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * JavaScript onclick event
     *
     * @return String
     */
    public function onclick()
    {
        return $this->getName().'.onclick();';
    }

    /**
     * Gibt den JavaScript Code mit create() des Tabs zurück
     *
     * @return String
     */
    public function create()
    {
        $jsString = 'var '.$this->getName().' = '.$this->jsObject();
        $jsString .= $this->_parent->getName().'.appendChild( '.$this->getName()
            .' );';

        return $jsString;
    }

    /**
     * Gibt den JavaScript Code des Tabs zurück
     *
     * @return String
     */
    public function jsObject()
    {
        $jsString = 'new QUI.controls.toolbar.Tab({';
        $attributes = $this->getAttributes();

        foreach ($attributes as $s => $value) {
            if ($s != 'name') {
                $jsString .= $s.' : "'.$value.'",';
            }
        }

        $jsString .= 'name: "'.$this->getName().'"';
        $jsString .= '});';

        return $jsString;
    }
}
