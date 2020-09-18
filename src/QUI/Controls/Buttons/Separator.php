<?php

/**
 * This file contains the \QUI\Controls\Buttons
 */

namespace QUI\Controls\Buttons;

use QUI;

/**
 * Button Separator
 *
 * @author  www.pcsg.de (Henning Leutz)
 */
class Separator extends QUI\QDOM
{
    /**
     * the Parent Object
     *
     * @var \QUI\Controls\Toolbar\Bar
     */
    private $Parent;

    /**
     * Constructor
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->setAttribute('type', 'QUI\\Controls\\Buttons\\Separator');
        $this->setAttributes($settings);
    }

    /**
     * Set the Parent
     *
     * @param \QUI\Controls\Toolbar\Bar $Parent
     */
    public function addParent($Parent)
    {
        $this->Parent = $Parent;
    }

    /**
     * get the name attribute
     *
     * @return String
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * Ertstellt den JavaScript Code und ruft die create Methode auf
     *
     * @return String
     */
    public function create()
    {
        return 'var '.$this->getAttribute('name').' = '
               .$this->jsObject().';'
               .$this->Parent->getName().'.appendChild( '
               .$this->getAttribute('name').' );';
    }

    /**
     * Ertstellt den JavaScript
     *
     * @return String
     */
    public function jsObject()
    {
        $jsString = 'new QUI.controls.buttons.Separator({';

        if ($this->getAttribute('height')) {
            $jsString .= 'height: "'.$this->getAttribute('height').'",';
        }

        $jsString .= 'name: "'.$this->getAttribute('name').'"';
        $jsString .= '})';

        return $jsString;
    }
}
