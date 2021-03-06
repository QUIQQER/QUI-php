<?php

/**
 * This file contains the \QUI\Controls\Contextmenu\Baritem
 */

namespace QUI\Controls\Contextmenu;

use QUI;

/**
 * ContextBarItem
 *
 * @author  www.pcsg.de (Henning Leutz)
 */
class Baritem extends QUI\QDOM
{
    /**
     * subitems
     *
     * @var array
     */
    private $items = [];

    /**
     * Parent Object
     *
     * @var \QUI\Controls\Control
     */
    private $Parent = null;

    /**
     * Disable status
     *
     * @var Bool
     */
    private $disabled = false;

    /**
     * Constructor
     *
     * @param array $settings
     * $settings['text'] = Text vom Button
     * $settings['name'] = Name vom JavaScript Objekt
     */
    public function __construct(array $settings)
    {
        $this->setAttributes($settings);
        $this->setAttribute('type', 'qui/controls/contextmenu/BarItem');
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Contextmenu\Bar $parent
     */
    public function addParent(Bar $parent)
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
     * Remove all children
     */
    public function clear()
    {
        $this->items = [];
    }

    /**
     * Ein ContextMenuItem hinzufügen
     *
     * @param \QUI\Controls\Contextmenu\Menuitem $itm
     *
     * @return \QUI\Controls\Contextmenu\Baritem (this)
     */
    public function appendChild($itm)
    {
        $this->items[] = $itm;

        return $this;
    }

    /**
     * Remove a child item
     *
     * @param string $name - Name of the child
     */
    public function removeChild($name)
    {
        $items = [];

        foreach ($this->items as $Item) {
            if ($name != $Item->getName()) {
                $items[] = $Item;
            }
        }

        $this->items = $items;
    }

    /**
     * Setzt den Menüpunkt inaktiv
     */
    public function setDisable()
    {
        $this->disabled = true;
    }

    /**
     * Macht einen inaktiven Menüpunkt wieder verfügbar
     */
    public function setEnable()
    {
        $this->disabled = false;
    }

    /**
     * Gibt ein Kind per Namen zurück
     *
     * @param String $name - Name des Menüeintrages
     *
     * @return Bool|\QUI\Controls\Contextmenu\Baritem
     */
    public function getElementByName($name)
    {
        foreach ($this->items as $itm) {
            if ($name == $itm->getName()) {
                return $itm;
            }
        }

        return false;
    }

    /**
     * Item als Array bekommen
     *
     * @return array
     */
    public function toArray()
    {
        $result          = $this->getAttributes();
        $result['items'] = [];

        foreach ($this->items as $Itm) {
            $Itm->addParent($this);
            $result['items'][] = $Itm->toArray();
        }

        return $result;
    }
}
