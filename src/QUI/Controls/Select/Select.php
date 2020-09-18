<?php

/**
 * This file contains \QUI\Controls\Select\Select
 */

namespace QUI\Controls\Select;

use QUI;

/**
 * Select Element
 * Erstellt eine Selectbox
 *
 * @author  www.pcsg.de (Henning Leutz)
 *
 * @todo    we need that?
 */
class Select extends QUI\QDOM
{
    /**
     * Parent Object
     *
     * @var \QUI\Controls\Control
     */
    private $Parent;

    /**
     * Sub items
     *
     * @var array
     */
    private $items = [];

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
     * Ein Optionfield hinzufügen
     *
     * @param \QUI\Controls\Select\Option $Option
     */
    public function appendChild(Option $Option)
    {
        $this->items[] = $Option;
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Toolbar\Bar $parent
     */
    public function addParent($parent)
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
     * Enter description here...
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->items;
    }

    /**
     * create the jsobject and the create
     *
     * @return String
     */
    public function create()
    {
        $jsString = 'var '.$this->getName().' = '.$this->jsObject().';';
        $jsString .= $this->Parent->getName().'.appendChild( '.$this->getAttribute('name').' );';

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

        $jsString = 'new _ptools.Select({'.
                    'name: "'.$this->getAttribute('name').'",';

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


        if (count($this->items) > 0) {
            foreach ($this->items as $itm) {
                $itm->addParent($this);
                $jsString .= '.appendChild('.$itm->jsObject().')';
            }
        }

        return $jsString;
    }
}
