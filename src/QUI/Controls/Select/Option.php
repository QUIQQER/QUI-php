<?php

/**
 * This file contains \QUI\Controls\Select\Option
 */

namespace QUI\Controls\Select;

use QUI;

/**
 * Option
 * Erstellt ein Optionfeld in einem _ptools Select Objekt
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.select
 *
 * @todo    we need that?
 */
class Option extends QUI\QDOM
{
    /**
     * Parent object
     *
     * @var \QUI\Controls\Select\Select
     */
    private $Parent;

    /**
     * constructor
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->setAttributes($settings);
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Select\Select $parent
     */
    public function addParent(QUI\Controls\Select\Select $parent)
    {
        $this->Parent = $parent;
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
     * create the jsobject and the create
     *
     * @return String
     */
    public function create()
    {
        $jsString = 'var '.$this->getName().' = '.$this->jsObject().';';
        $jsString
                  .=
            $this->Parent->getAttribute('name').'.appendChild( '.$this->getName()
            .' );';

        return $jsString;
    }

    /**
     * create only the jsobject
     *
     * @return String
     */
    public function jsObject()
    {
        $attributes = $this->getAttributes();

        $jsString = 'new _ptools.Option({
            name: "'.$this->getName().'",';

        foreach ($attributes as $key => $setting) {
            if ($key != 'name' && $key != 'text') {
                $jsString .= $key.': '.json_encode($setting).',';
            }
        }

        if ($this->getAttribute('text')) {
            $jsString .= 'text: "'.$this->getAttribute('text').'"';
        } else {
            $jsString .= 'text: ""';
        }

        $jsString .= '})';

        return $jsString;
    }
}
