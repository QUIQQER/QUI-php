<?php

/**
 * This file contains \QUI\Controls\Loader\Progress
 */

namespace QUI\Controls\Loader;

use QUI;

/**
 * Class Progress
 *
 * @package QUI\Controls\Loader
 */
class Progress extends QUI\Controls\Control
{
    /**
     * Progress constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->addCSSFile(
            QUI\Controls\Handler::getInstance()->getConfig('QUI_PATH').'qui/controls/loader/Progress.css'
        );

        $this->addCSSClass('qui-progress');
        $this->setModule('qui/controls/loader/Progress');
    }

    /**
     * Create the DOMNode String
     *
     * @return string
     */
    public function onCreate()
    {
        if ($this->getAttribute('global')) {
            $this->addCSSClass('qui-progress-global');
        }

        $styles  = $this->getStyles();
        $classes = $this->getCSSClasses();

        $style = '';
        $class = '';

        if (!empty($styles)) {
            $parts = [];

            foreach ($styles as $key => $value) {
                $parts[] = htmlentities($key).':'.htmlentities($value);
            }

            $style = implode(';', $parts);
        }

        if (!empty($classes)) {
            $class = array_keys($this->getCSSClasses());
            $class = implode(' ', $class);
        }

        return '<div data-qui="'.$this->module.'" class="'.$class.'" style="'.$style.'">
            <div class="qui-progress-bar" style="width: 100px"></div>
        </div>';
    }
}
