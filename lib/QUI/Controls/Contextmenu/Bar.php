<?php

/**
 * This file contains the \QUI\Controls\Contextmenu\Bar
 */

namespace QUI\Controls\Contextmenu;

/**
 * ContextBar
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.php.controls.contextmenu
 */

class Bar extends \QUI\QDOM
{
    /**
     * subitems
     * @var array
     */
    private $_items = array();

    /**
     * Konstruktor
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->setAttributes( $settings );
        $this->setAttribute( 'type', 'qui/controls/contextmenu/Bar' );
    }

    /**
     * Ein ContextBarItem in die ContextBar hinzufügen
     *
     * @param \QUI\Controls\Contextmenu\ $Itm
     */
    public function appendChild(\QUI\Controls\Contextmenu\Baritem $Itm)
    {
        $this->_items[] = $Itm;
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
     * Gibt ein Kind per Namen zurück
     *
     * @param String $name - Name des Menüeintrages
     * @return Bool | ContextBarItem
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
     * Alle Kinder bekommen
     *
     * @return Array
     */
    public function getChildren()
    {
        return $this->_items;
    }

    /**
     * Return a children by path
     *
     * @param String $path - /child/child/child/
     * @return Ambigous <\QUI\Controls\Contextmenu\Bar, boolean, unknown>
     */
    public function getElementByPath($path)
    {
        $path   = explode( '/', $path );
        $Parent = $this;

        foreach ( $path as $parent )
        {
            $_Parent = $Parent->getElementByName( $parent );

            if ( $_Parent ) {
                $Parent = $_Parent;
            }
        }

        return $Parent;
    }

    /**
     * Menü als Array bekommen
     *
     * @return Array
     */
    public function toArray()
    {
        $result = array();

        foreach ( $this->_items as $Itm )
        {
            $Itm->addParent($this);
            $result[] = $Itm->toArray();
        }

        return $result;
    }
}
