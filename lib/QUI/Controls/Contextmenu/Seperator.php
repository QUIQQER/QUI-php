<?php

/**
 * This file contains the \QUI\Controls\Contextmenu\Seperator
 */

namespace QUI\Controls\Contextmenu;

/**
 * \QUI\Controls\Contextmenu\Seperator
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.contextmenu
 */

class Seperator extends \QUI\QDOM
{
    /**
     * The Parent Object
     * @var \QUI\Controls\Control
     */
    private $_parent = null;

    /**
     * Constructor
     *
     * @param array $settings
     * $settings['name'] = Name vom JavaScript Objekt
     *
     */
    public function __construct(array $settings)
    {
        $this->setAttributes( $settings );
        $this->setAttribute( 'type', 'qui/controls/contextmenu/Seperator' );
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Buttons\Button|
     * 		  \QUI\Controls\Contextmenu\Baritem|
     * 		  \QUI\Controls\Contextmenu\Menuitem $parent
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

        throw new Exception(
            'Argument 1 passed to '. get_class( $this ) .'::addParent() must be an instance of Button or ContextBarItem '
        );
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
     * Enter description here...
     *
     * @return String
     */
    public function create()
    {
        $jsString = 'var '. $this->getAttribute('name') .' = new _ptools.ContextMenuSeperator({'.
            'name: "'. $this->getAttribute('name') .'"';
        $jsString .= '});';
        $jsString .= $this->_parent->getName() .'.appendChild('. $this->getAttribute('name') .');';

        return $jsString;
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function getHtml()
    {
        return '<li class="divider"></li>';
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function toArray()
    {
        return $this->getAllAttributes();
    }
}
