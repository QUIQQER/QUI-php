<?php

/**
 * This file contains the \QUI\Controls\Contextmenu\Separator
 */

namespace QUI\Controls\Contextmenu;

use QUI;

/**
 * \QUI\Controls\Contextmenu\Separator
 *
 * @author  www.pcsg.de (Henning Leutz)
 */
class Separator extends QUI\QDOM
{
    /**
     * The Parent Object
     *
     * @var \QUI\Controls\Control
     */
    private $Parent = null;

    /**
     * Constructor
     *
     * @param array $settings
     * $settings['name'] = Name vom JavaScript Objekt
     *
     */
    public function __construct(array $settings)
    {
        $this->setAttributes($settings);
        $this->setAttribute('type', 'qui/controls/contextmenu/Separator');
    }

    /**
     * Parent setzen
     *
     * @param \QUI\Controls\Buttons\Button|\QUI\Controls\Contextmenu\Baritem|\QUI\Controls\Contextmenu\Menuitem $parent
     *
     * @return Bool
     * @throws QUI\Exception
     */
    public function addParent($parent)
    {
        if (get_class($parent) == QUI\Controls\Buttons\Button::class
            || get_class($parent) == Baritem::class
            || get_class($parent) == Menuitem::class
        ) {
            $this->Parent = $parent;

            return true;
        }

        throw new QUI\Exception(
            'Argument 1 passed to '.get_class($this)
            .'::addParent() must be an instance of Button or ContextBarItem '
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
        $jsString = 'var '.$this->getAttribute('name')
                    .' = new _ptools.ContextMenuSeparator({'
                    .'name: "'.$this->getAttribute('name').'"'
                    .'});'
                    .$this->Parent->getName().'.appendChild('
                    .$this->getAttribute('name').');';

        return $jsString;
    }

    /**
     * Enter description here...
     *
     * @return String
     */
    public function getHtml()
    {
        return '<li class="divider"></li>';
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getAttributes();
    }
}
