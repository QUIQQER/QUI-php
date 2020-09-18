<?php

/**
 * This file contains the \QUI\Controls\Toolbar\Bar
 */

namespace QUI\Controls\Toolbar;

/**
 * Toolbar Bar
 *
 * @author  www.pcsg.de (Henning Leutz)
 */
class Bar
{
    /**
     * all settings from the toolbar
     *
     * @var array
     */
    private $settings = [];

    /**
     * all subitems from the toolbar
     *
     * @var array
     */
    private $items = [];

    /**
     * constructor
     *
     * @param array $settings
     *  parent = id vom Parent HTML Element in welches die Toolbar eingefügt werden soll
     *  name = Objektname der Toolbar
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Fügt ein Kind ein
     *
     * @param \QUI\Controls\Sitemap\Item|
     *        \QUI\Controls\Toolbar\Tab|
     *        \QUI\Controls\Buttons\Button|
     *        \QUI\Controls\Buttons\Separator $itm
     *
     * @return \QUI\Controls\Toolbar\Bar this
     */
    public function appendChild($itm)
    {
        $this->items[] = $itm;

        return $this;
    }

    /**
     * Namen vom Objekt bekommen
     *
     * @return string
     */
    public function getName()
    {
        return $this->settings['name'];
    }

    /**
     * JavaScript Clear
     *
     * @return string
     */
    public function clear()
    {
        return $this->settings['name'].'.clear();';
    }

    /**
     * Gibt die Items zurück
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Erstellt den JavaScriptbereich um eine ContextBar mit seinen Kindern aufzubauen
     *
     * @return string
     */
    public function create()
    {
        $jsString = 'var '.$this->settings['name'].' = '.$this->jsObject();
        $jsString .= 'document.getElementById("'.$this->settings['parent']
                     .'").appendChild('.$this->settings['name'].'.create());';

        return $jsString;
    }

    /**
     * Gibt den JavaScript Code des Tabs zurück
     *
     * @return string
     */
    public function jsObject()
    {
        $jsString = 'new QUI.controls.toolbar.Bar({';

        foreach ($this->settings as $s => $value) {
            if ($s != 'name') {
                $jsString .= $s.' : "'.$value.'",';
            }
        }

        $jsString .= 'name : "'.$this->settings['name'].'"';
        $jsString .= '});'."\n";

        foreach ($this->items as $itm) {
            $itm->addParent($this);
            $jsString .= $itm->create()."\n";
        }

        return $jsString;
    }

    /**
     * Sucht ein Item in der Toolbar nach dem Namen und gibt dieses zurück
     *
     * @param string $name
     *
     * @return Bool|
     * \QUI\Controls\Sitemap\Item|
     * \QUI\Controls\Toolbar\Tab|
     * \QUI\Controls\Buttons\Button|
     * \QUI\Controls\Buttons\Separator
     */
    public function getElementByName($name)
    {
        foreach ($this->items as $itm) {
            if ($itm->getName() == $name) {
                return $itm;
                break;
            }
        }

        return false;
    }

    /**
     * Löscht ein Kind aus der Toolbar
     *
     * @param Object $Child - Das Kind Objekt
     */
    public function removeChild($Child)
    {
        foreach ($this->items as $key => $Itm) {
            if ($Itm == $Child) {
                unset($this->items[$key]);
            }
        }
    }

    /**
     * Gibt das erste Kind zurück
     *
     * @return object|false
     */
    public function firstChild()
    {
        if (!isset($this->items[0])) {
            return false;
        }

        return $this->items[0];
    }

    /**
     * Gibt alle Kinder zurück
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->items;
    }

    /**
     * Nur die das JavaScript der Kinder bekommen
     * appendChild der Toolbar wird hier nicht ausgegeben
     *
     * @return string
     */
    public function createChildJs()
    {
        $jsString = '';

        foreach ($this->items as $itm) {
            $itm->addParent($this);
            $jsString .= $itm->create();
        }

        return $jsString;
    }

    /**
     * Alle Kinder als Array bekommen
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach ($this->items as $Itm) {
            $result[] = $Itm->getAllAttributes();
        }

        return $result;
    }
}
