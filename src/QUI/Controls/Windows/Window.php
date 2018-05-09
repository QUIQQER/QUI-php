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
    protected $TYPE = 'QUI\\Controls\\Windows\\Window';

    /**
     * categories - \QUI\Controls\Buttons\Button
     *
     * @var array
     */
    protected $categories = [];

    /**
     * buttons - \QUI\Controls\Buttons\Button
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * constructor
     *
     * @param array $settings
     */
    public function __construct($settings = [])
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
        $this->categories[] = $Btn;
    }

    /**
     * Return the Categories
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Remove all categories
     */
    public function clearCategories()
    {
        $this->categories = [];
    }

    /**
     * Add a button
     *
     * @param \QUI\Controls\Buttons\Button $Btn
     */
    public function appendButton(Button $Btn)
    {
        $this->buttons[] = $Btn;
    }

    /**
     * Return the Buttons
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Return the window as an array
     *
     * @return array
     */
    public function toArray()
    {
        $result = $this->getAttributes();

        $result['categories'] = [];
        $result['buttons']    = [];

        foreach ($this->categories as $Itm) {
            $Itm->addParent($this);
            $result['categories'][] = $Itm->toArray();
        }

        foreach ($this->buttons as $Itm) {
            $Itm->addParent($this);
            $result['buttons'][] = $Itm->toArray();
        }

        return $result;
    }
}
