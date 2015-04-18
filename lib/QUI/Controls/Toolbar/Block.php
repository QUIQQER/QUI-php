<?php

/**
 * This file contains the \QUI\Controls\Toolbar\Block
 */

namespace QUI\Controls\Toolbar;

use QUI;

/**
 * Toolbar Block
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.toolbar
 */

class Block extends QUI\QDOM
{
    /**
     * The parent object
     *
     * @var \QUI\Controls\Control
     */
    private $_parent;

    /**
     * The sub items
     *
     * @var array
     */
    private $_items;

    /**
     * Constructor
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        foreach ($settings as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * Parent setzen
     *
     * @param Toolbar $parent
     */
    public function addParent(\QUI\Controls\Toolbar\Bar $parent)
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
     * JavaScript für Onclick
     *
     * @return String
     */
    public function onclick()
    {
        return $this->getName().'.onclick();';
    }

    /**
     * Ein Kind anhängen
     *
     * @param unknown_type $itm
     */
    public function appendChild($itm)
    {
        $this->_items[] = $itm;
    }

    /**
     * Gibt den JavaScript Code des Blocks zurück und erstellt gleichzeitig die Variable
     *
     * @return String
     */
    public function create()
    {
        $jsString = 'var '.$this->getName().' = ';
        $jsString .= $this->_parent->getName().'.appendChild( '.$this->getName()
            .' );';

        return $jsString;
    }

    /**
     * Gibt den JavaScript Code des Blocks zurück
     *
     * @return String
     */
    public function jsObject()
    {
        $jsString = 'new _ptools.ToolbarBlock({';

        $attributes = $this->getAllAttributes();

        foreach ($attributes as $s => $value) {
            if ($s != 'name') {
                $jsString .= $s.' : '.json_encode($value).',';
            }
        }

        $jsString .= 'name: "'.$this->getName().'"';
        $jsString .= '})';

        if (count($this->_items) > 0) {
            foreach ($this->_items as $itm) {
                $itm->addParent($this);
                $jsString .= '.appendChild('.$itm->jsObject().')';
            }
        }

        return $jsString;
    }
}
