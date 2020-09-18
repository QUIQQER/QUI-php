<?php

/**
 * This file contains the \QUI\Controls\Contextmenu\Menuitem
 */

namespace QUI\Controls\Contextmenu;

use QUI;

/**
 * ContextMenuItem
 *
 * @author  www.pcsg.de (Henning Leutz)
 */
class Menuitem extends QUI\QDOM
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
     * @var \QUI\Controls\Contextmenu\Bar
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
     * $settings['image'] = Menubild
     */
    public function __construct($settings = [])
    {
        $this->setAttributes($settings);
        $this->setAttribute('type', 'qui/controls/contextmenu/Item');
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Contextmenu\Baritem | \QUI\Controls\Buttons\Button $parent
     *
     * @return Bool
     * @throws \QUI\Exception
     */
    public function addParent($parent)
    {
        if (get_class($parent) == 'QUI\\Controls\\Buttons\\Button'
            || get_class($parent) == 'QUI\\Controls\\Contextmenu\\Baritem'
            || get_class($parent) == 'QUI\\Controls\\Contextmenu\\Menuitem'
        ) {
            $this->Parent = $parent;

            return true;
        }

        throw new QUI\Exception(
            'Argument 1 passed to ContextMenuItem::addParent()
             must be an instance of QUI\\Controls\\Buttons\\Button or QUI\\Controls\\Contextmenu\\Bar '
            .
            get_class($parent).' given'
        );
    }

    /**
     * Sortiert die Kinder
     */
    public function sortChildren()
    {
        $_children = [];
        $children  = $this->items;

        foreach ($children as $Itm) {
            $_children[$Itm->getAttribute('text')] = $Itm;
        }

        ksort($_children);

        $this->items = $_children;
    }

    /**
     * Ein Kind hinzufügen
     *
     * @param \QUI\Controls\Contextmenu\Menuitem|\QUI\Controls\Contextmenu\Separator $child
     *
     * @return \QUI\Controls\Contextmenu\Menuitem (this)
     */
    public function appendChild($child)
    {
        if (get_class($child) == Menuitem::class
            || get_class($child) == Separator::class
        ) {
            $this->items[] = $child;
        }

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
     * Kinder bekommen
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->items;
    }

    /**
     * Gibt ein Kind per Namen zurück
     *
     * @param String $name - Name des Menüeintrages
     *
     * @return Bool | \QUI\Controls\Contextmenu\Menuitem
     */
    public function getElementByName($name)
    {
        foreach ($this->items as $Item) {
            if ($name == $Item->getName()) {
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
        return $this->getAttribute('name');
    }

    /**
     * Setzt den Menüpunkt inaktiv
     */
    public function setDisable()
    {
        $this->disabled = true;
    }

    /**
     * Setzt den Menüpunkt inaktiv
     */
    public function isDisable()
    {
        if ($this->disabled) {
            return true;
        }

        return false;
    }

    /**
     * Macht einen inaktiven Menüpunkt wieder verfügbar
     */
    public function setEnable()
    {
        $this->disabled = false;
    }

    /**
     * Setzt den Menüpunkt inaktiv
     */
    public function isEnable()
    {
        if ($this->disabled) {
            return false;
        }

        return true;
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

        foreach ($this->items as $Itm) {
            $Itm->addParent($this);
            $result['items'][] = $Itm->toArray();
        }

        return $result;
    }
}
