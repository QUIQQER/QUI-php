<?php

/**
 * This file contains the \QUI\Controls\Buttons\Button
 */

namespace QUI\Controls\Buttons;

use QUI;

/**
 * QUI Button
 *
 * @author  www.pcsg.de (Henning Leutz)
 */
class Button extends QUI\QDOM
{
    /**
     * The Parent
     *
     * @var object
     */
    private $Parent;

    /**
     * Sub Items
     *
     * @var array
     */
    private $items = [];

    /**
     * Disable status
     *
     * @var boolean
     */
    private $disabled = false;

    /**
     * constructor
     *
     * @param array $settings
     */
    public function __construct($settings = [])
    {
        $this->setAttribute('type', 'QUI\\Controls\\Buttons\\Button');
        $this->setAttributes($settings);
    }

    /**
     * set the parent to the button
     *
     * @param \QUI\Controls\Toolbar\Bar $Parent
     */
    public function addParent($Parent)
    {
        $this->Parent = $Parent;
    }

    /**
     * Get the name attribute
     *
     * @return string
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
        $this->disabled = true;
    }

    /**
     * Add an context item to the button
     *
     * @param \QUI\Controls\Contextmenu\Menuitem $mitem
     */
    public function appendChild(QUI\Controls\Contextmenu\Menuitem $mitem)
    {
        $this->items[] = $mitem;
    }

    /**
     * Return the window as an array
     *
     * @return array
     */
    public function toArray()
    {
        $result          = $this->getAttributes();
        $result['items'] = [];

        foreach ($this->items as $Itm) {
            try {
                /* @var $Itm QUI\Controls\Contextmenu\Menuitem */
                $Itm->addParent($this);

                $result['items'][] = $Itm->toArray();
            } catch (QUI\Exception $Exception) {
                QUI\System\Log::writeException($Exception);
            }
        }

        return $result;
    }
}
