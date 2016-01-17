<?php

/**
 * This file contains the \QUI\Controls\Sitemap\Map
 */

namespace QUI\Controls\Sitemap;

use QUI;

/**
 * Sitemap
 * Baut eine Sitemap
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.sitemap
 */
class Map extends QUI\QDOM
{
    /**
     * Sub Items
     * @var array
     */
    private $items = array();

    /**
     * Konstruktor
     *
     * @param array $settings
     *  parent = id vom Parent HTML Element in welches die ContextBar eingefügt werden soll
     *  id = id des DivElements der ContextBar
     *  name = Objektname der Contextbar
     */
    public function __construct(array $settings)
    {
        $this->setAttributes($settings);
    }

    /**
     * Ein ContextBarItem in die ContextBar hinzufügen
     *
     * @param \QUI\Controls\Sitemap\Item $itm
     */
    public function appendChild(Item $itm)
    {
        $this->items[] = $itm;
    }

    /**
     * Namen vom Objekt bekommen
     *
     * @return String
     * @deprecated Es sollte getAttribute('name') verwendet werden
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * Erstellt das JavaScript für eine Sitemap
     *
     * @return String
     */
    public function create()
    {
        $jsString = 'var ' . $this->getAttribute('name') . ' = new _ptools.Sitemap();';

        foreach ($this->items as $itm) {
            $itm->addParent($this);
            $jsString .= $itm->create();
        }

        $jsString .= 'document.getElementById("' . $this->getAttribute('parent') . '")
        .appendChild(' . $this->getAttribute('name') . '.create());';
        return $jsString;
    }
}
