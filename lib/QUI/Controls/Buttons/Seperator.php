<?php

/**
 * This file contains the \QUI\Controls\Buttons
 */

namespace QUI\Controls\Buttons;

/**
 * Button Seperator
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.buttons
 */

class Seperator extends \QUI\QDOM
{
    /**
     * the settings array
     * @var array
     */
    private $_settings;

    /**
     * the Parent Object
     * @var \QUI\Controls\Control
     */
    private $_parent;

    /**
     * Constructor
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->setAttribute('type', 'QUI\\Controls\\Buttons\\Seperator');
        $this->setAttributes($settings);
    }

    /**
     * Set the Parent
     *
     * @param \Controls\Toolbar\Bar $Parent
     */
    public function addParent($Parent)
    {
        $this->_parent = $Parent;
    }

    /**
     * get the name attribute
     *
     * @return String
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * Ertstellt den JavaScript Code und ruft die create Methode auf
     *
     * @return String
     */
    public function create()
    {
        $jsString  = 'var '. $this->getAttribute('name') .' = '. $this->jsObject() .';';
        $jsString .= $this->_parent->getName().'.appendChild( '. $this->getAttribute('name') .' );';

        return $jsString;
    }

    /**
     * Ertstellt den JavaScript
     *
     * @return String
     */
    public function jsObject()
    {
        $jsString  = 'new QUI.controls.buttons.Seperator({';

        if($this->getAttribute('height')) {
            $jsString .= 'height: "'. $this->getAttribute('height') .'",';
        }

        $jsString .= 'name: "'. $this->getAttribute('name') .'"';
        $jsString .= '})';

        return $jsString;
    }
}