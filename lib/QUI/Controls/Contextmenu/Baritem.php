<?php

/**
 * This file contains the \QUI\Controls\Contextmenu\Baritem
 */

namespace QUI\Controls\Contextmenu;

/**
 * ContextBarItem
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.contextmenu
 */

Class Baritem extends \QUI\QDOM
{
    /**
     * subitems
     * @var array
     */
    private $_items = array();

    /**
     * Parent Object
     * @var \QUI\Controls\Control
     */
    private $_parent = null;

    /**
     * Disable status
     * @var Bool
     */
    private $_disabled = false;

    /**
     * Constructor
     *
     * @param array $settings
     * $settings['text'] = Text vom Button
     * $settings['name'] = Name vom JavaScript Objekt
     */
    public function __construct(array $settings)
    {
        $this->setAttributes( $settings );
        $this->setAttribute( 'type', 'qui/controls/contextmenu/BarItem' );
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Contextmenu\Bar $parent
     */
    public function addParent(\QUI\Controls\Contextmenu\Bar $parent)
    {
        $this->_parent = $parent;
    }

    /**
     * Namen vom Objekt bekommen
     *
     * @return String
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * Ein ContextMenuItem hinzufügen
     *
     * @param \QUI\Controls\Contextmenu\Menuitem $itm
     * @return \QUI\Controls\Contextmenu\Baritem (this)
     */
    public function appendChild($itm)
    {
        $this->_items[] = $itm;
        return $this;
    }

    /**
     * Setzt den Menüpunkt inaktiv
     */
    public function setDisable()
    {
        $this->_disabled = true;
    }

    /**
     * Macht einen inaktiven Menüpunkt wieder verfügbar
     */
    public function setEnable()
    {
        $this->_disabled = false;
    }

    /**
     * Gibt ein Kind per Namen zurück
     *
     * @param String $name - Name des Menüeintrages
     * @return Bool|\QUI\Controls\Contextmenu\Baritem
     */
    public function getElementByName($name)
    {
        foreach ( $this->_items as $itm )
        {
            if ( $name == $itm->getName() ) {
                return $itm;
            }
        }

        return false;
    }

    /**
     * Item als Array bekommen
     *
     * @return Array
     */
    public function toArray()
    {
        $result = $this->getAllAttributes();
        $result['items'] = array();

        foreach ( $this->_items as $Itm )
        {
            $Itm->addParent($this);
            $result['items'][] = $Itm->toArray();
        }

        return $result;
    }
}
