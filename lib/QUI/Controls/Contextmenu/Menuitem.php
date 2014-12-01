<?php

/**
 * This file contains the \QUI\Controls\Contextmenu\Menuitem
 */

namespace QUI\Controls\Contextmenu;

use QUI;

/**
 * ContextMenuItem
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.contextmenu
 */

Class Menuitem extends QUI\QDOM
{
    /**
     * subitems
     * @var array
     */
    private $_items = array();

    /**
     * Parent Object
     * @var \QUI\Controls\Contextmenu\Bar
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
     * $settings['image'] = Menubild
     */
    public function __construct($settings=array())
    {
        $this->setAttributes( $settings );
        $this->setAttribute( 'type', 'qui/controls/contextmenu/Item' );
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Contextmenu\Baritem | \QUI\Controls\Buttons\Button $parent
     * @return Bool
     * @throws \QUI\Exception
     */
    public function addParent($parent)
    {
        if ( get_class( $parent ) == 'QUI\\Controls\\Buttons\\Button' ||
             get_class( $parent ) == 'QUI\\Controls\\Contextmenu\\Baritem' ||
             get_class( $parent ) == 'QUI\\Controls\\Contextmenu\\Menuitem' )
        {
            $this->_parent = $parent;
            return true;
        }

        throw new QUI\Exception(
            'Argument 1 passed to ContextMenuItem::addParent()
             must be an instance of QUI\\Controls\\Buttons\\Button or QUI\\Controls\\Contextmenu\\Bar '.
            get_class( $parent ).' given'
        );
    }

    /**
     * Sortiert die Kinder
     */
    public function sortChildren()
    {
        $_children = array();
        $children  = $this->_items;

        foreach ( $children as $Itm ) {
            $_children[ $Itm->getAttribute( 'text' ) ] = $Itm;
        }

        ksort( $_children );

        $this->_items = $_children;
    }

    /**
     * Ein Kind hinzufügen
     *
     * @param \QUI\Controls\Contextmenu\Menuitem|\QUI\Controls\Contextmenu\Seperator $child
     * @return \QUI\Controls\Contextmenu\Menuitem (this)
     */
    public function appendChild($child)
    {
        if ( get_class( $child ) == 'QUI\\Controls\\Contextmenu\\Menuitem' ||
             get_class( $child ) == 'QUI\\Controls\\Contextmenu\\Seperator' )
        {
            $this->_items[] = $child;
        }

        return $this;
    }

    /**
     * Kinder bekommen
     *
     * @return Array
     */
    public function getChildren()
    {
        return $this->_items;
    }

    /**
     * Gibt ein Kind per Namen zurück
     *
     * @param String $name - Name des Menüeintrages
     * @return Bool | \QUI\Controls\Contextmenu\Menuitem
     */
    public function getElementByName($name)
    {
        foreach ( $this->_items as $Item )
        {
            if ( $name == $Item->getName() ) {
                return $Item;
            }
        }

        return false;
    }

    /**
     * Namen vom Objekt bekommen
     *
     * @return String
     */
    public function getName()
    {
        return $this->getAttribute( 'name' );
    }

    /**
     * Setzt den Menüpunkt inaktiv
     */
    public function setDisable()
    {
        $this->_disabled = true;
    }

    /**
     * Setzt den Menüpunkt inaktiv
     */
    public function isDisable()
    {
        if ( $this->_disabled ) {
            return true;
        }

        return false;
    }

    /**
     * Macht einen inaktiven Menüpunkt wieder verfügbar
     */
    public function setEnable()
    {
        $this->_disabled = false;
    }

    /**
     * Setzt den Menüpunkt inaktiv
     */
    public function isEnable()
    {
        if ( $this->_disabled ) {
            return false;
        }

        return true;
    }

    /**
     * Item als Array bekommen
     *
     * @return Array
     */
    public function toArray()
    {
        $result = $this->getAttributes();
        $result['items'] = array();

        /*
        if ( $this->getAttribute( 'onClick' ) ) {
            $result['events']['onClick'] = $this->getAttribute( 'onClick' );
        }

        if ( $this->getAttribute( 'onMouseDown' ) ) {
            $result['events']['onMouseDown'] = $this->getAttribute( 'onMouseDown' );
        }

        if ( $this->getAttribute( 'onMouseUp' ) ) {
            $result['events']['onMouseUp'] = $this->getAttribute( 'onMouseUp' );
        }
        */

        foreach ( $this->_items as $Itm )
        {
            $Itm->addParent( $this );
            $result['items'][] = $Itm->toArray();
        }

        return $result;
    }
}
