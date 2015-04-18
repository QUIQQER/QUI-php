<?php

/**
 * This file contains the \QUI\Controls\Sitemap\Item
 */

namespace QUI\Controls\Sitemap;

use QUI;

/**
 * SitemapItem
 * Erstellt ein Sitemap Eintrag
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.controls.sitemap
 */

class Item extends QUI\QDOM
{
    /**
     * sub items
     *
     * @var array
     */
    private $_items = array();

    /**
     * parent object
     *
     * @var \QUI\Controls\Control
     */
    private $_parent = null;

    /**
     * Konstruktor
     *
     * @param array $settings -
     *                        $settings['text'] = Text vom Button
     *                        $settings['name'] = Name vom JavaScript Objekt
     *                        $settings['icon'] = Sitemap Icon
     */
    public function __construct(array $settings)
    {
        $this->setAttributes($settings);
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Sitemap\Map $Parent
     */
    public function addParent(\QUI\Controls\Sitemap\Map $Parent)
    {
        $this->_parent = $Parent;
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
     * @param \QUI\Controls\Sitemap\Item $itm
     */
    public function appendChild(\QUI\Controls\Sitemap\Item $itm)
    {
        $this->_items[] = $itm;
    }

    /**
     * create the javascript
     *
     * @param Bool $append - append the child to the parent
     *
     * @return String
     */
    public function create($append = true)
    {
        $jsString = 'var '.$this->getName().'=';
        $jsString .= $this->createJsObject().';';

        foreach ($this->_items as $itm) {
            $itm->addParent($this);
            $jsString .= $itm->create();
        }

        if ($append == true) {
            $jsString
                .= $this->parent->getName().'.appendChild('.$this->getName()
                .');';
        }

        return $jsString;
    }

    /**
     * Erstellt ein JavaScript SitemapItem Objekt
     *
     * @return String
     */
    public function createJsObject()
    {
        $allattributes = $this->getAllAttributes();
        $jsString = 'new _ptools.SitemapItem({';

        foreach ($allattributes as $key => $setting) {
            if ($key != 'name' && $key != 'text') {
                $jsString .= $key.': '.json_encode($setting).',';
            }
        }

        $jsString .= 'text: '.json_encode($this->getAttribute('text'));
        $jsString .= '})';

        return $jsString;
    }
}
