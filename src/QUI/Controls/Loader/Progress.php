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
            QUI\Controls\Handler::getInstance()->getConfig('QUI_PATH') . 'qui/controls/loader/Progress.css'
        );
    }

    /**
     * Create the DOMNode String
     *
     * @return string
     */
    public function onCreate()
    {
        return '<div data-qui="qui/controls/loader/Progress" class="qui-progress-bar"></div>';
    }
}
