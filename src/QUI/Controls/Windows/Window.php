<?php

/**
 * This file contains \QUI\Controls\Windows\Window
 */

namespace QUI\Controls\Windows;

use QUI;
use QUI\Controls\Buttons\Button;

/**
 * Window control class
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.windows
 */
class Window extends QUI\QDOM
{
    /**
     * control type
     *
     * @var String
     */
    protected $_TYPE = 'QUI\\Controls\\Windows\\Window';

    /**
     * categories - \QUI\Controls\Buttons\Button
     *
     * @var array
     */
    protected $_categories = array();

    /**
     * buttons - \QUI\Controls\Buttons\Button
     *
     * @var array
     */
    protected $_buttons = array();

    /**
     * constructor
     *
     * @param array $settings
     */
    public function __construct($settings = array())
    {
        $this->setAttributes($settings);
    }

    /**
     * Add a category
     *
     * @param \QUI\Controls\Buttons\Button $Btn
     */
    public function appendCategory(Button $Btn)
    {
        $this->_categories[] = $Btn;
    }

    /**
     * Return the Categories
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->_categories;
    }

    /**
     * Remove all categories
     */
    public function clearCategories()
    {
        $this->_categories = array();
    }

    /**
     * Add a button
     *
     * @param \QUI\Controls\Buttons\Button $Btn
     */
    public function appendButton(Button $Btn)
    {
        $this->_buttons[] = $Btn;
    }

    /**
     * Return the Buttons
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->_buttons;
    }

    /**
     * Return the window as an array
     *
     * @return Array
     */
    public function toArray()
    {
        $result = $this->getAttributes();

        $result['categories'] = array();
        $result['buttons'] = array();

        foreach ($this->_categories as $Itm) {
            $Itm->addParent($this);
            $result['categories'][] = $Itm->toArray();
        }

        foreach ($this->_buttons as $Itm) {
            $Itm->addParent($this);
            $result['buttons'][] = $Itm->toArray();
        }

        return $result;
    }
}
