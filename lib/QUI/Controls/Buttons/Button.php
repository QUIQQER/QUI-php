<?php

/**
 * This file contains the \QUI\Controls\Buttons\Button
 */

namespace QUI\Controls\Buttons;

/**
 * QUI Button
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.buttons
 */

class Button extends \QUI\QDOM
{
    /**
     * The Parent
     * @var \QUI\Controls\Control
     */
    private $_parent;

    /**
     * Sub Items
     * @var array
     */
    private $_items = array();

    /**
     * Disable status
     * @var Bool
     */
    private $_disabled = false;

    /**
     * constructor
     *
     * @param array $settings
     */
    public function __construct($settings=array())
    {
        $this->setAttribute( 'type', 'QUI\\Controls\\Buttons\\Button' );
        $this->setAttributes( $settings );
    }

    /**
     * set the parent to the button
     *
     * @param \QUI\Controls\Toolbar\Bar $Parent
     */
    public function addParent($Parent)
    {
        $this->_parent = $Parent;
    }

    /**
     * Get the name attribute
     *
     * @return String
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * disable the button
     */
    public function setDisable()
    {
        $this->_disabled = true;
    }

    /**
     * Add an context item to the button
     *
     * @param \QUI\Controls\Contextmenu\Menuitem $mitem
     */
    public function appendChild(\QUI\Controls\Contextmenu\Menuitem $mitem)
    {
        $this->_items[] = $mitem;
    }

    /**
     * Return the window as an array
     *
     * @return Array
     */
    public function toArray()
    {
        $result = $this->getAllAttributes();
        $result['items'] = array();

        foreach ( $this->_items as $Itm )
        {
            $Itm->addParent( $this );
            $result['items'][] = $Itm->toArray();
        }

        return $result;
    }
}
